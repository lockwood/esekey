<?php

define('LABEL', 0);
define('DESCRIPTION', 1);
define('TYPE', 2);
define('VALIDATION', 3);
define('MAXLENGTH', 4);
define('NAME', 5);
define('RELATIONSHIP', 6);
define('RELATIONTYPE', 7);


require_once("HTML/Table.php");
/** 
 * ObjectDef is populated with info from CSV files in /ddf folder.
 * One instance of ObjetDef is created per CSV file.
 */
class ObjectDef {
	var $name;
	var $description;
	var $fields;
	var $uniqueFields;
	var $relations;
	var $keys;

 
	function ObjectDef() {
		$this->fields = array();
		$this->uniqueFields = array();
		$this->relations = array();
		$this->keys = array();
	}
 
  
	/**
	 * Return true of the provided relation ship is of the form
	 * hasSome(Object,LinkObject), false otherwise.
	 **/
	function isNxNRelationship($rel) {
		if (preg_match("/,/", $rel[RELATIONTYPE])) return true;
		return false;
	}
	
	/**
	 * Given a relationship return the type of the end of the relation
	 * ship, e.g: User rather than RoleMembership for a
	 * hasSome(User,RoleMembership) type relation.
	 */
	function getEndType($rel) {
		$types = split(",", $rel[RELATIONTYPE]);
		return $types[0];
	}

	/**
	 * Given an NxN relationship return the type of linking
	 * table/object ship, e.g: RoleMembership rather than User for a
	 * hasSome(User,RoleMembership) type relation.
	 */
	function getLinkingType($rel) {
		$types = split(",", $rel[RELATIONTYPE]);
		return $types[1];
	}
}

// Each array is a hash of objectname->code, e.g. 'Brand->php class'
$sql = array();
$php = array();
$html = array();
$diagram = array();


// get a list of all csv files that are in the ddf directory.
$ddfDir="ddf";
$objectDDFs = getDdfFileNames($ddfDir);

$objects = array();
foreach ($objectDDFs as $ddf) {
	print("Parsing file $ddfDir/$ddf\n");
	$objectDef = parseFile("$ddfDir/$ddf");
	$objects[$objectDef->name] = $objectDef;
}

// elementary error checking, make sure every class referenced in a
// relationship actually has a definition.
foreach ($objects as $oDef) {
  foreach ($oDef->relations as $rel) {
    $type = ObjectDef::getEndType($rel);
    if (!array_key_exists($type, $objects)) {
      print "Reference to unknown class '$type' in relation ".$oDef->name."->".$rel[LABEL]."\n";
    }
  }
}

generateSQLSchema($sql,  $objects);
generatePHPClasses($php, $objects);
generateHTMLDocs($html, $objects);
generateDiagrams($diagram, $objects);

writeFiles($sql, $php, $html, $diagram);

exit;

/**
 * Given a directory, return all Data Definition Files (DDF) that are
 * within.  A file is considered a DDF file if its name begins with an
 * Uppercase letter, and ends with '.csv'.
 **/
function &getDdfFileNames($dir) {
  $dh  = opendir($dir);
  while (false !== ($filename = readdir($dh))) {
    if(preg_match("/^[A-Z].*[.]csv$/", $filename)) {
      $objectDDFs[] = $filename;
    } 
  }
  closedir($dh);
	
  return $objectDDFs;
}
	
/**
 * Given a set of arrays representing code in a variety of languages,
 * produce appropriate files on the file system.

 * Each array passed in is a map from object name -> object code
 * in the appropriate language.  Language here means one of sql, php,
 * html, dotty (diagram).
 *

 * File are currently generated in generated/sql, generated/php and
 * generated/docs
 */
function writeFiles($sql, $php, $html, $diagram) {
	foreach ($sql as $tableName=>$createStatement) {
		$fh = fopen("SQL_Schema/".$tableName."_create.sql", "w");
		fwrite($fh, $createStatement);
		fclose($fh);
	}

	foreach ($php as $className=>$classCode) {
		$fh = fopen("DB_DataObjects/".$className."_DataObject.class.php", "wb");
		fwrite($fh, "<?php\r\n$classCode\r\n\r\n ?>");
		fclose($fh);
	}

	$allFh = fopen("HTML_Docs/all.html", "wb");
	foreach ($html as $className=>$classDocs) {
		$fh = fopen("HTML_Docs/".$className.".html", "wb");
		fwrite($fh, "$classDocs");
		fwrite($allFh, "$classDocs");
		fclose($fh);
	}

	foreach ($diagram as $object=>$dottySrc) {
		$fh = fopen("HTML_Docs/".$object.".dot", "wb");
		fwrite($fh, "digraph $object {\n $dottySrc \n}");
		fclose($fh);
	}
}

/**
* Parse the provided CSV file and return a populated objectDef object.
*/
function parseFile($filename) {
	$handle = fopen($filename, "r");
		
  if (!$handle) die("Couldn't open '$filename'");

  $objectName = false;
  $objectDescription = false;
  $uniqueFields = array();
  $relations = array();
  $fields = array();
  $keys = array();

  while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
    // skip blank lines and '//' style comments.
    if (!$data[0] ||
				preg_match("{^\s*//}", $data[0])) continue;

    if (!$objectName) {
      $objectName=$data[0];
      if (count($data)>1)
				$objectDescription=$data[1];
      else 
				print("Warning: no description for $objectName\n");
      continue;
    }
    
    $data[VALIDATION]=explode(",", $data[VALIDATION]);

    if (array_search("unique", $data[VALIDATION])) {
      array_push($uniqueFields, $data);
      
    }

    if (preg_match("/^(hasSome|hasA|belongsTo|contains)[(](.*)[)]/", $data[TYPE], $matches)) {
      $data[RELATIONSHIP]=$matches[1];
      $data[RELATIONTYPE]=$matches[2];
      array_push($relations, $data);
      if ($data[RELATIONSHIP] == "hasA") {
				$keys[] = $data[NAME]."_id";
      }
    } else {
      array_push($fields, $data);
    }
  }

  fclose($handle);

  $objectDef = new ObjectDef;
  $objectDef->name   = $objectName;
  $objectDef->description   = $objectDescription;
  $objectDef->fields = $fields;
  $objectDef->uniqueFields = $uniqueFields;
  $objectDef->relations = $relations;
  $objectDef->keys = $keys;
  $objectDef->keys[] = strtolower($objectName."_id");
	return $objectDef;
}

function getRelationshipDiagramLabels($objectDef) {
  $names = array();
  foreach ($objectDef->relations as $rel) {
	$names[] = "<".$rel[NAME].">". $rel[LABEL];
  }
  return $names;
}

/**
 *	Generate diagram of tables and relationships.  Creates a Graphviz
 *	(http://www.graphviz.org/), dot file.
 */
function generateDiagrams(&$diagram, &$objects) {
	$diagram["AllObjects"]="";

	foreach ($objects as $objectDef) {
		$diagram[$objectDef->name]=generateObjectDiagram($objectDef);

		$diagram["AllObjects"].=generateOverviewDiagram($objectDef);
	}
}

function generateOverviewDiagram($objectDef) {
	$dotty = "// Source for $objectDef->name \n";
	$dotty.= 'node [shape="Mrecord"]'."\n";
	foreach ($objectDef->relations as $rel) {
		if ($rel[RELATIONSHIP] == "hasA") {
			$dotty.=sprintf('%s[shape="Mrecord"]'."\n", ObjectDef::getEndType($rel));
			$dotty.=sprintf('%s -> %s[label="%s"]'."\n", 
							 $objectDef->name, $rel[RELATIONTYPE], "");
		} elseif ($rel[RELATIONSHIP] == "hasSome"||
				  $rel[RELATIONSHIP] == "contains"||
				  $rel[RELATIONSHIP] == "belongsTo") {
			if (ObjectDef::isNxNRelationship($rel)) {
				$dotty.=sprintf('%s -> %s'."\n", 
								$objectDef->name, ObjectDef::getLinkingType($rel));
				$dotty.=sprintf('%s [shape="plaintext"]'."\n", ObjectDef::getLinkingType($rel));
				$dotty.=sprintf('%s-> %s'."\n",ObjectDef::getLinkingType($rel), ObjectDef::getEndType($rel));
				$dotty.=sprintf('%s[peripheries=3 shape="Mrecord"]'."\n", ObjectDef::getEndType($rel));
			} else {
				$dotty.=sprintf('%s[peripheries=3 shape="Mrecord"]'."\n", ObjectDef::getEndType($rel));
				$dotty.=sprintf('%s -> %s'."\n", $objectDef->name, ObjectDef::getEndType($rel));
			}
		}
	}
	return $dotty;
}

function generateObjectDiagram($objectDef) {
	$dotty = "// Source for $objectDef->name \n";
	$dotty.= 'node [shape="Mrecord"]'."\n";
	$dotty.=sprintf('%s[label="{<%s>%s|{%s}}"]'."\n", $objectDef->name, $objectDef->name, $objectDef->name,
					join("|", getRelationshipDiagramLabels($objectDef)));
	foreach ($objectDef->relations as $rel) {
		if ($rel[RELATIONSHIP] == "hasA") {
			$dotty.=sprintf('%s[peripheries=1 shape="box"]'."\n", ObjectDef::getEndType($rel));
			$dotty.= sprintf('%s:%s -> %s[label="%s"]'."\n", 
							 $objectDef->name, $rel[NAME], $rel[RELATIONTYPE], "");
		} elseif ($rel[RELATIONSHIP] == "hasSome"||
				  $rel[RELATIONSHIP] == "contains"||
				  $rel[RELATIONSHIP] == "belongsTo") {
			if (ObjectDef::isNxNRelationship($rel)) {
				$dotty.=sprintf('%s:%s -> %s'."\n", 
								$objectDef->name, $rel[NAME], ObjectDef::getLinkingType($rel));
				$dotty.=sprintf('%s [shape="plaintext"]'."\n", ObjectDef::getLinkingType($rel));
				$dotty.=sprintf('%s-> %s'."\n",ObjectDef::getLinkingType($rel), ObjectDef::getEndType($rel));
				$dotty.=sprintf('%s[peripheries=3 shape="box"]'."\n", ObjectDef::getEndType($rel));
			} else {
				$dotty.=sprintf('%s[peripheries=3 shape="box"]'."\n", ObjectDef::getEndType($rel));
				$dotty.=sprintf('%s:%s -> %s'."\n", $objectDef->name, $rel[NAME], ObjectDef::getEndType($rel));
			}
		}
	}
	return $dotty;
}


/**
*	Generate HTML documentation.
*/
function generateHTMLDocs(&$html, &$objects) {
	foreach ($objects as $objectDef) {
		$docs = "<h1>$objectDef->name</h1>";
		$docs.= "$objectDef->description <br/>";
		$dataTable = new HTML_Table(array("border"=>1, "style"=>"border-style: solid;", "width"=>"100%"));
		$dataTable -> setAutoGrow(true);
		$dataTable -> setAutoFill("&nbsp;");
		$row =0;
		$col =0;
		$dataTable -> setHeaderContents($row, $col++, "Label");
		$dataTable -> setHeaderContents($row, $col++, "Description");
		$dataTable -> setHeaderContents($row, $col++, "Type");
		$dataTable -> setHeaderContents($row, $col++, "Validation");
		$dataTable -> setHeaderContents($row, $col++, "Max length");
		$dataTable -> setRowAttributes(0, array("bgcolor"=>"black", 
												"style"=>"color: white; font-size: 10pt; font-family: arial;"), true);
		$row++;
		foreach ($objectDef->fields as $field) {
			$col = 0;
			$dataTable -> setCellContents($row, $col++, $field[LABEL]);
			$dataTable -> setCellContents($row, $col++, $field[DESCRIPTION]);
			$dataTable -> setCellContents($row, $col++, $field[TYPE]);
			$dataTable -> setCellContents($row, $col++, getValidationDescription($field[VALIDATION]));
			$dataTable -> setCellContents($row, $col++, $field[MAXLENGTH] ? $field[MAXLENGTH] : "n/a");
			$dataTable -> setRowAttributes($row, array("style"=>"color: black; font-size: 10pt; font-family: arial;"), true);
			$row++;
		}

		$relTable = new HTML_Table(array("border"=>1, "style"=>"border-style: solid;", "width"=>"100%"));
		$relTable -> setAutoGrow(true);
		$relTable -> setAutoFill("&nbsp;");
		$row =0;
		$col =0;
		$relTable -> setHeaderContents($row, $col++, "Label");
		$relTable -> setHeaderContents($row, $col++, "Description");
		//  $relTable -> setHeaderContents($row, $col++, "Relationship");
		$relTable -> setRowAttributes(0, array("bgcolor"=>"black", "style"=>"color: white; font-size: 10pt; font-family: arial;"), true);
		$row ++;
		
		foreach ($objectDef->relations as $rel) {
			$col = 0;
			$relTable -> setCellContents($row, $col++, $rel[LABEL]);
			$relTable -> setCellContents($row, $col++, $rel[DESCRIPTION]);
			
			if ($rel[RELATIONSHIP] == "hasA") $relationship = "has a ".$rel[RELATIONTYPE];
			elseif ($rel[RELATIONSHIP] == "hasSome") $relationship = "has some ".$rel[RELATIONTYPE]."s";
			elseif ($rel[RELATIONSHIP] == "belongsTo") $relationship = "belongs to some ".$rel[RELATIONTYPE]."s";
			elseif ($rel[RELATIONSHIP] == "contains") $relationship = "contains some ".$rel[RELATIONTYPE]."s";
			//    $relTable -> setCellContents($row, $col++, $relationship );
			$relTable -> setRowAttributes($row, array("style"=>"color: black; font-size: 10pt; font-family: arial;"), true);
			$row++;
		}

		$docs .= "<h2>Data held</h2>\n";
		$docs .= "The following data is held for each $objectDef->name\n";
		$docs .= $dataTable->toHtml();
		
		$docs .= "<h2>Relationships</h2>\n";
		$docs .= "Each $objectDef->name has the following relationships with other objects within PWT.";
		$docs .= "<h3>Relationship table</h3>";
		$docs .= $relTable->toHtml();
		$docs .= "<h3>$objectDef->name Relationship Diagram</h3>";
		$docs .= sprintf("<img src='%s.gif' align=center>", $objectDef->name);

		$html[$objectDef->name]=$docs;
	}
}

/**
 * Return a human readable version of the validation string provided,
 * for display and documenation purposes.
 **/
function getValidationDescription($validators) {
	$matches=0;
	if (preg_match("/select\((.*)\)/", join(",", $validators), $matches)) {
		$text = "One of the list:<br>";
		foreach (split(",", $matches[1]) as $option) {
			$values=preg_split("/=>/", $option);
			$text.=$values[0].", ";
		}
		return $text;
	} else {
		return join(",", $validators);
	}
} 

/**
 *	Generate PHP class code.
 */
function generatePHPClasses(&$php, &$objects) {
	foreach ($objects as $objectDef) {
		$varDeclarations = getVarDeclarations($objectDef);
		$accessorDefinitions = getAccessors($objectDef);
		$formDefinitions = getFormDefinition($objectDef);
		$formValidations = getValidators($objectDef);
		$tableDeclarations = getTableDefinition($objectDef);
		
		foreach ($objectDef->relations as $relation) {

			if ($relation[RELATIONSHIP] == "hasA") {
				$accessorDefinitions[]=getPHPHasAAccessors($relation);

			} elseif ($relation[RELATIONSHIP] == "hasSome" ||
					  $relation[RELATIONSHIP] == "belongsTo" ||
					  $relation[RELATIONSHIP] == "contains") {
      
				//  This may be an N to N relation of form hasSome(ContainedClass, RelationshipClass)
				//  or a 1 to N relation of form hasSome(ContainedClass)
				if (ObjectDef::isNxNRelationship($relation)) {
					list ($type, $relationName) = explode(",",$relation[RELATIONTYPE]);
			
					$accessorDefinitions[] = getPHPNxNAccessor($objectDef, $relation);
				} else {
					// 1 to N case, e.g. hasSome(Comments)
					$accessorDefinitions[] = getPHP1xNAccessor($objectDef, $relation);
				} 
			} else {      
				die("Unknown relationship type ".$field[RELATIONSHIP]." in ".$objectDef->name);
			}
		}

		$php[$objectDef->name] = getPHPDataObjectClass(	$objectDef, $varDeclarations, $accessorDefinitions, 
														$formDefinitions, $formValidations);
	}
}

/**
 * This generates the get and set methods from the database field
 * names.
 * @return array of get/set accessor definitions
 */
function getAccessors($objectDef) {
	$accessorDefinitions=array();
	foreach ($objectDef->fields as $field) {
		$accessorDefinitions[] = generateSetAccessor($field);
		$accessorDefinitions[] = generateGetAccessor($field);
	}
	return $accessorDefinitions;
} // getAccessors
		

function generateSetAccessor($field) {
	$fieldName = $field[NAME];
	$accessorName = getPHPVarName($field[NAME]);
	return "
	/**
	* Set method for $fieldName
	* ".$field[DESCRIPTION]."
	* @param string $fieldName.
	* @return bool true on success

	*/
	function set${accessorName}(\$value)  {
		if (\$this->$fieldName = \$value) { return true;} 
		else {return false; }
	}
";
}

function generateGetAccessor($field) {
    $fieldName = $field[NAME];
	$accessorName = getPHPVarName($field[NAME]);
	return "
	/**
	* Get method for $fieldName.
	* ".$field[DESCRIPTION]."
	* @return string $fieldName
	*/
	function get${accessorName}() {
		return \$this->$fieldName;
	}
";
}
		
	
		
/**
 *	Assign the validation parameters for form inputs.
 *	All inputs are trimmed with quickform trim filter.
 *	Phone and fax must have a length of 7-20, ()#+- are allowed
 */
function getValidators($objectDef) {
	$validators = array();
	
	foreach($objectDef->fields as $rule) {
			
			//check for unique fields and create a test
			if(sizeof($objectDef->uniqueFields) > 0) {
		
			$validators[] = sprintf('$form->registerRule("checkuniquefield", "callback", "checkUniqueField","%s_DataObject"); // the function then the class appear as param3 and param4, skip 4 if it is just a function outside a class', $objectDef->name);  
			
			
	} // sizeof unique fields
			

		//use trim for all input fields
		$validators[] = sprintf('		$form->applyFilter("%s", "trim"); ', $rule[NAME]);
		
		// validation contains an array of requirements....		
		foreach($rule[VALIDATION] as $is_required) {
			
			
			if($is_required == 'required') {
	
			// marked as required in the csv
			$validators[] = sprintf('		$form->addRule("%s", "%s", "%s");', 
										$rule[NAME],  $rule[LABEL]. " is required.", "required");
			
			} // is_required == required		
			
				
			if($is_required == 'unique') {
			
			// marked as required in the csv

			$validators[] = sprintf(' $form->addRule("%s", "%s", "%s");', 
									  $rule[NAME],  $rule[LABEL]. " must be unique.", "checkuniquefield"); // (reg rule only!)callback in php man, array of class and f name to supply an object
			
				} // check for unique
				
			} // foreach in validation array
			
			
		if($rule[NAME] == 'email') {
			// check email format
			
			$validators[] = sprintf('		$form->addRule("%s", "%s", "%s");', 
									$rule[NAME],  $rule[LABEL]. " address does not appear to be valid.", "email");
			
		} // check email address
		
		if(($rule[NAME] == 'phone') || ($rule[NAME] == 'fax')) {
			
			
			$validators[] = sprintf(' $form->addRule("%s", "%s", "%s", "%s");', 
									  $rule[NAME],  $rule[LABEL]. " number does not appear to be a valid one.", "regex", "([0-9,\s,#,+,\-,\(,\)]{7,20})");
			} // check numbers
					
	} // foreach objectdef fields as rule
		
	
		
		return $validators;
		
		
		} // get validators
	

function getVarDeclarations($objectDef) {
  $varDeclarations = array();
  foreach ($objectDef->fields as $field) {
    $varDeclarations[]=sprintf('	var $%s; // %s %s: %s', 
															 $field[NAME], $field[TYPE], $field[LABEL], $field[DESCRIPTION]);
    
  }
  
	foreach ($objectDef->relations as $relation) {
      
		if ($relation[RELATIONSHIP] == "hasA") {
			$varDeclarations[]=sprintf("	var \$%s_id ; // hasA link to %s table", $relation[NAME],
																 strtolower($relation[RELATIONTYPE]));
		}
	} 
	return $varDeclarations;
}

function getFormDefinition($objectDef) {
	$formDefinitions = array();
	$formDefinitions[] = sprintf('		$elements["%s_id"] = HTML_QuickForm::createElement("hidden", "%s_id");',
								 strtolower($objectDef->name), strtolower($objectDef->name));
	
	foreach ($objectDef->fields as $field) {
		// If the field is marked as 'noedit' in its validation
		// field, then use a hidden form element.
		if (in_array("noedit",$field[VALIDATION])) {
			$formDefinitions[] = sprintf('		$elements["%s"] = HTML_QuickForm::createElement("hidden", "%s");',
										 $field[NAME], $field[NAME]);

		// 	If the object is of type "freetext" then use a textare
		} elseif ($field[TYPE] == "freetext") {
			$formDefinitions[]=sprintf('		$elements["%s"] = HTML_QuickForm::createElement("%s", "%s", "%s");', 
									   $field[NAME], "textarea", $field[NAME], $field[LABEL]);
		} elseif ($field[TYPE] == "text"||
				  $field[TYPE] == "integer") {
			
			// If the validation field is of the form 'select(option1,option2,option3)'
			// then split the options to get array("option1","option2","option3")
			// The createSelect function is then used to create the actual QuickForm Elment.
			if (preg_match("/^select\((.*)\\)/", join(",", $field[VALIDATION]), $matches)) {
				$options = array();
				foreach (split(",", $matches[1]) as $option) {
					if (preg_match("/^(.*)=>(.*)$/", $option, $matches)) {
						$options[$matches[2]]=$matches[1];
					} else {
						$options[$option]=$option;
					}
				}
				$formDefinitions[]=createSelect($field[NAME], $field[LABEL], $options);
			} else {
				$formDefinitions[]=sprintf('
		$elements["%s"] = HTML_QuickForm::createElement("%s", "%s", "%s");
		$elements["%s"]->setMaxLength(%s); ', 

																	 $field[NAME], $field[TYPE], $field[NAME], 
																	 $field[LABEL], $field[NAME], $field[MAXLENGTH]);
		//archtectural spike
		// add hidden field array of unique items to test in HTML_Quickform::process()															 
		if(in_array( 'unique', $field[VALIDATION])){
		
			
		
	$formDefinitions[]=sprintf('
		$elements["checkUnique[]"] = HTML_Quickform::createElement("hidden", "checkUnique[]" );
		$elements["checkUnique[]"]->setValue("%s");', $field[NAME]);
			
		}	

		
		
		 
      }
    } elseif ($field[TYPE] == "boolean") {
      $formDefinitions[]=createSelect($field[NAME], $field[LABEL],  array(1=>"True", 0=>"False"));
    } elseif ($field[TYPE] == "password") {
      $formDefinitions[]=sprintf('
		$elements["%s"] = HTML_QuickForm::createElement("%s", "%s", "%s");
		$elements["%s"]->setMaxLength(%s); ', 

																	 $field[NAME], $field[TYPE], $field[NAME], 
																	 $field[LABEL], $field[NAME], $field[MAXLENGTH]);
    } else {
      print(" ##Unknown type ".$field[TYPE]." for label ".$field[LABEL]."\n");
    }
  }

	foreach ($objectDef->relations as $rel) {
		// if this is a hasA relation and we have a validation field of the form
		// select(Brand.name) then create the appropriate form
		if ($rel[RELATIONSHIP] == "hasA" && preg_match("/^select\((.*)[.](.*)\)\$/", join(",", $rel[VALIDATION]), $matches)) {
			$objectName = $matches[1]; $field = $matches[2];
			if ($objectName != $rel[RELATIONTYPE]) 
				printf("Warning, mismatch between validation type (%s) and relation type (%s)\n", $objectName, $rel[RELATIONTYPE]);
			$key = $rel[NAME]."_id";
			$formDefinitions[] = sprintf('		$elements["%s"] = HTML_QuickForm::createElement("select", "%s", "%s", %s::getHasASelectOptions(new %s, "%s"));',
																	 $key, $key, $rel[LABEL], $objectDef->name."_DataObject", "${objectName}_DataObject", $field);
		} elseif ($rel[RELATIONSHIP] == "hasA") {
			$formDefinitions[] = sprintf('		$elements["%s_id"] = HTML_QuickForm::createElement("hidden", "%s_id");',
																	 $rel[NAME], $rel[NAME]);
		}
	}

  return $formDefinitions;
}

function getTableDefinition($objectDef) {
  // currently unimplemented, as DataObject does a good job of
  // guessing for us at runtime.  SHould be implemented if runtime
  // performence becomes an issue.
}

function getPHP1xNAccessor($objectDef, $relation) {
  if (!array_key_exists(NAME, $relation)) {
		print "No name found for relation $objectDef->name -> ".$relation[LABEL]."\n";
  }
  
	$methodName = getPHPVarName($relation[NAME]);
	
	$fieldName = $relation[NAME];
	$returnType = $relation[RELATIONTYPE];
	$objectName = $objectDef->name;
	return "

	/**
	* Add some objects of type ${returnType}_DataObject to the list of $methodName 
	* on this object.  This takes immediate effect (no update required), and is only
	* valid on an object that exists within the database.

	* A single $returnType can be passed instead of an array.
	*/
	function add${methodName}(&\$array) {
		if (!is_array(\$array)) \$array=array(\$array);
		foreach (\$array as \$object) {
			\$array->set${objectName}(\$this);
			\$array->update();
		}
	}

	/**
	* Get an array of ${returnType}_DataObject that are associated with
	* this object.

	* This is a convenience function, if large numbers of objects are to
	* be returned then it will be more memory efficient to use the find()
	* and fetch() methods of ${returnType}_DataObject directly.
	* @param string orderBy what to use as the orderBy clause
	* @param string the type that the returned objects should be.
	* @return array of ${returnType}_DataObject objects.
	*/
	function &get${methodName}(\$orderBy=false, \$type='${returnType}_DataObject') {
		\$array = array();
		\$finder = new \$type;
		\$finder->set${objectName}(\$this);
		\$finder->find();
		while (\$finder->fetch()) {
			\$array[] = clone(\$finder);
		}
		return \$array;
	}
";
}


function getPHPNXNAccessor($objectDef, $relation) {
	$methodName = getPHPVarName($relation[NAME]);
	$fieldName = $relation[NAME];
	$returnTypeArray =  explode( ',' ,$relation[RELATIONTYPE]);
	$returnType = $returnTypeArray[1];
	$relationTo = $returnTypeArray[0];
	
	$objectName = $objectDef->name;
	return "

	/**
	* Remove entries to the list of $methodName 
	* on this object.  
	* A single ".strtolower($relationTo)." can be passed instead of an array.
	* @param array \$array. An array of ".strtolower($relationTo)." to remove.
	*/
	function remove${methodName}(&\$array,  \$table='".strtolower($returnType)."', \$objectName=".strtolower($objectName).") {
		\$table1 = \$table;
		\$table2 = '".strtolower($relationTo)."';
	
		if (!is_array(\$array)) \$array=array(\$array);
		foreach (\$array as \$object) {
			\$query = \"DELETE FROM \$table1 WHERE  \".\$objectName.\"_id = '\".\$this->getId().\"' and ".strtolower($relationTo)."_id = \$object->getId()\";
			\$this->query(\$query);
			\$this->fetch();
		}
	}

	/**
	* Add object IDs to the list of $methodName 
	* on this object.  
	* A single ".strtolower($relationTo)." can be passed instead of an array.
	* @param array \$array. An array of ".strtolower($relationTo)." to add.
	*/
	function add${methodName}(&\$array,  \$table='".strtolower($returnType)."', \$objectName=".strtolower($objectName).") {
		\$table1 = \$table;
	
		if (!is_array(\$array)) \$array=array(\$array);
	
		foreach (\$array as \$object) {
			\$query = \"INSERT INTO \$table1 values( '\".\$object->getId().\"', '\".\$this->getId.\"') \";
			\$this->query(\$query);
			\$this->fetch();
		}
	}

	/**
	* Get an array of ".strtolower($relationTo)." objects that are associated with
	* this object.
	* @param string the table name of the membership table that the names are linked through.
	* @return array of ".strtolower($relationTo)." strings.
	*/
	function &get${methodName}( \$table='".strtolower($returnType)."') {
		\$array = array();
		\$table1 = \$table;
		\$table2 = '".strtolower($relationTo)."';

		\$query = \"SELECT \$table1.* , ".strtolower($relationTo).".".strtolower($relationTo)."_id AS return_id FROM \$table1, \$table2 WHERE \$table1.user_id = '\".\$this->getId().\"' AND \$table1.\".\$table2.\"_id = \$table2.\".\$table2.\"_id \";
		\$this->query(\$query);
		while (\$this->fetch()) {
				\$array[] = clone(DB_DataObject::staticGet(\$this->return_id, '".$relationTo."'));
		}
		return \$array;	
	}
	
	";		
}
		
function generateUniqueCheck($objectDef) {

	if(sizeof($objectDef->uniqueFields) > 0) {

$uniqueChecker=sprintf('
				/**
				*\@return array of field names failed 
				*\@desc This function checks any indicated fields for uniqueness in their table column
				*/
				function checkUniqueField($field_value) {
				
				foreach($_POST["checkUnique"] as $fieldname) {
				
				$test_object = DB_DataObject::factory("%s");
				$evil_string = "\$test_object->set$fieldname(\"\$field_value\");";
				eval($evil_string);	
				$count = $test_object->find();
		
					
					if(($count > 1)){
						return false;

					} // if		

				
					} // foreach

			return true;
				} //function
				
				
				
								
			', $objectDef->name, $objectDef->name);

return $uniqueChecker;

	}
}

function getPHPDataObjectClass($objectDef, $varDeclarations, 
															 $accessorDefinitions, $formDefinitions=false, $formValidations=false) {
	$objectName = $objectDef->name;
  $tableName = strtolower($objectName);
  $objectName = $objectName."_DataObject";
  if (!$formDefinitions) $formDefinitions=array();
  if (!$formValidations) $formValidations=array();

  return "
require_once('DB/DataObject.php');
require_once('HTML/QuickForm.php');

/**
* $objectDef->description
*/
class $objectName extends DB_DataObject {
	var \$__table='$tableName';
	var \$${tableName}_id;	// Primary key
".join("\n", $varDeclarations)."

	/* ZE2 Compatibility trick */
	function __clone() { return \$this; }

	function staticGet(\$k, \$v=NULL) { return DB_DataObject::staticGet('$objectName', \$k, \$v); }

	/**
	* Returns the id of this object.
	*/
	function getId() {
		return \$this->${tableName}_id;
	}

	/**
	* Sets the name of this object.
	*/
	function setId(\$id) {
		\$this->${tableName}_id = \$id;
	}
  
  

  
  

".join("\n", $accessorDefinitions)."

	/**
	* Returns a QuickForm object that for this data object.
	* @param string action.  The HTML form action attribute to use.
	* @param string target.  The HTML form target attribute to use.
	* @param string formName.  The HTML form name attribute to use.
	* @param string method.   The HTML form method attribute to use.
	* @param array elementOrder. If provided only the elements
	* listed will be in the final form, in the order given.
	*/
	function &getForm(\$action=false, \$target='_self', \$formName='$objectName', 
			  \$method='post', \$elementOrder=false) {
		\$form =& new HTML_QuickForm(\$formName, \$method, SELF, \$target);
		\$elements = ${objectName}::getFormElements(\$form, \$elementOrder);
		// Validation rules
".join("\n", $formValidations)."
		return \$form;
	}

	function &getFormElements(&\$form, \$elementOrder=false) {
		\$elements=array();
".join("\n", $formDefinitions)."
		if (!\$elementOrder) {
			\$elementOrder = array_keys(\$elements);
		}
		foreach (\$elementOrder as \$elementName) {
			\$form->addElement(\$elements[\$elementName]);
		}
	}

	function getHasASelectOptions(\$object, \$displayField) {
		\$options = array();
		\$object->find();
		while (\$object->fetch()) {
			\$options[\$object->getId()] = \$object->\$displayField;
		}
		return \$options;
	}
  
  
  ".generateUniqueCheck($objectDef)."
  
}";
}

function getPHPVarName($name) {
  $varName="";
  foreach (explode("_", $name) as $word)
    $varName.=ucfirst($word);
  return $varName;
}

function generateSQLSchema(&$sql, &$objects){
	foreach ($objects as $objectDef) {
		$objectName = strtolower($objectDef->name);
		$primaryKeyName = "${objectName}_id";
		
		$create = 
			"CREATE TABLE $objectName (\n".
			"  -- data fields\n".
			"	$primaryKeyName INT UNSIGNED NOT NULL AUTO_INCREMENT, \n";
		
		foreach ($objectDef->fields as $field) {
			$create.=sprintf("\t%s %s,\n", $field[NAME], getSQLType($field));
		}
		
		$create.=
			"  -- Foreign Keys\n";
		
		foreach ($objectDef->relations as $field) 
		{
			if ($field[RELATIONSHIP] == "hasA") 
			{
				$create.=sprintf("\t%s_id INT UNSIGNED,\n", $field[NAME]);
				
			} elseif (	$field[RELATIONSHIP] == "hasSome" ||
						$field[RELATIONSHIP] == "belongsTo" ||
						$field[RELATIONSHIP] == "contains") 
						{
				
				//  This may be an N to N relation of form hasSome(ContainedClass, RelationshipClass)
				//  or a 1 to N relation of form hasSome(ContainedClass)
				if (preg_match("/,/", $field[RELATIONTYPE])) {
					list ($type, $relationName) = explode(",",$field[RELATIONTYPE]);
					$relationName=strtolower($relationName);
					$create.=sprintf("  -- %s %s relation will be implemented in %s table\n", 
													 $field[LABEL], $field[TYPE], $relationName);
					
					$relationSql=getMembershipTableSQL($relationName, $objectName, $type);
					
					if (!array_key_exists($relationName, $sql)) {
						$sql[$relationName]=$relationSql;
					} else {
						if ($sql[$relationName]!= $relationSql) {
							print($sql[$relationName]);
							print($relationSql);
							die("Inconsistent relation $relationName between $objectName and $type");
						}
					}
				} else {
					$create.=sprintf("  -- %s %s relation will be implemented in %s table\n", 
													 $field[LABEL], $field[TYPE], $field[RELATIONTYPE]);
				} 
			} else {
				die("Unknown relationship type ".$field[RELATIONSHIP]." in $objectName");
			}
		}

		$create.=
			"  -- Contraints\n";
		
		foreach ($objectDef->uniqueFields as $field) {
			$create.=sprintf("\tUNIQUE KEY(%s),\n", $field[NAME]);
		}
		
		$create.=sprintf("\tPRIMARY KEY(%s));\n", $primaryKeyName);
		
		$sql[$objectName]=$create;
	}
}

function getSQLType($field) {
  $type=$field[TYPE]; $size=$field[MAXLENGTH];
  if ($type == "text") 		return "VARCHAR($size)";
  if ($type == "freetext") 	return "TEXT";
  if ($type == "integer") 	return "INT";
  if ($type == "boolean") 	return "BOOL";
  if ($type == "timestamp") return "TIMESTAMP";
  if ($type == "date") 		return "DATE";
  if ($type == "money")		return "INT";

  die ("Unknown type '$type' for label ". $field[LABEL]);
}

function getMembershipTableSQL($relationName, $memberObjectName, $containerObjectName) {
  $relationName = strtolower($relationName);
  $memberObjectName = strtolower($memberObjectName);
  $containerObjectName = strtolower($containerObjectName);

  $createString=("CREATE TABLE %s (\n".
								 "\t%s_id INT UNSIGNED NOT NULL,\n".
								 "\t%s_id INT UNSIGNED NOT NULL);\n");
  if (strcmp($memberObjectName, $containerObjectName) < 0) {
    return sprintf($createString, 
									 $relationName, $memberObjectName, $containerObjectName);
  } else {
    return sprintf($createString, 
									 $relationName, $containerObjectName, $memberObjectName);
  }
}


function getPHPHasAAccessors($relation) {
  $relationName = $relation[NAME];
  $relationType = $relation[RELATIONTYPE]; // the type of the class we are related to.

  $phpVarName = getPHPVarName($relationName);
  $relationId = strtolower($relationType)."_id";
  return "
	/**
	* Set the $phpVarName $relationType object.
	* @param mixed either an $relationType object, or an object id
	* @returns true on success, otherwise a string describing a failure
	*/
	function set${phpVarName}(\$${phpVarName}) {
		if (is_object(\$$phpVarName)) \$this->${relationName}_id = \$${phpVarName}->${relationId};
		else \$this->${relationName}_id = (int)\$${phpVarName};
		return true;
	}

	/**
	* Get the $phpVarName $relationType object.
	* @return null or a $relationType instance
	**/
	function get${phpVarName}() {
		if (is_null(\$this->${relationName}_id)) return null; 
		else return ${relationType}_DataObject::staticGet(\$this->${relationName}_id);
	}
";

}  


function createSelect($name, $label, $options) {
  $arrayText=array();
  foreach ($options as $n=>$l) {
    $arrayText[]="\"$n\"=>\"$l\"";
  }
  return sprintf('
		$elements["%s"] = HTML_QuickForm::createElement("%s", "%s", "%s", array(%s));',
								 $name, "select", $name, $label, join(",",$arrayText ));
}

?>
