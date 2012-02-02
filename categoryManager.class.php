<?php

  class categoryManager {

    private $categoryArray;

    private $categoryArrayByCategoryId;

    private $idKey;
    private $parentIdKey;
    private $nameKey;  

    function __construct($categoryArray, $idKey, $parentKey, $nameKey) {

      $this->categoryArray = $categoryArray;

      $this->idKey = $idKey;
      $this->parentIdKey = $parentKey;
      $this->nameKey = $nameKey;

      foreach ($this->categoryArray as $category) {
      
        $categoryArrayByCategoryId[$category[$this->idKey]][$this->nameKey] = $category[$this->nameKey];
        $categoryArrayByCategoryId[$category[$this->idKey]][$this->parentIdKey] = $category[$this->parentIdKey];

      }
      
      $this->categoryArrayByCategoryId = $categoryArrayByCategoryId; 

    }

    public function getChildCategories($id) {

      $childCategoryArray = array();

      foreach($this->categoryArray as $category) {

        if ($category[$this->parentIdKey] == $id) {

          array_push($childCategoryArray,$category);
  
        } 

      }

      return $childCategoryArray;

    }

    public function getChildCategoriesRecurring($id, $childCategoryArray = array()) {

      foreach($this->categoryArray as $category) {

        if ($category[$this->parentIdKey] == $id) {
          
          array_push($childCategoryArray, $category[$this->idKey]);

          $childCategoryArray = $this->getChildCategoriesRecurring($category[$this->idKey], $childCategoryArray);

        }

      }
      
      return $childCategoryArray; 

    }

    public function getCategoryParentID($id) {
      
      if (isset($this->categoryArrayByCategoryId[$id][$this->parentIdKey])) {

        return $this->categoryArrayByCategoryId[$id][$this->parentIdKey];

      } else {

        return 0;

      }
 
    }

    public function getCategoryName($id) {
      
      if (isset($this->categoryArrayByCategoryId[$id][$this->nameKey])) {

        return $this->categoryArrayByCategoryId[$id][$this->nameKey];

      } else {

        return 0;

      }
 
    }

    public function makeCategoryTreeArray($sortedArray = array(), $currentCategory = 0, $level = 0) {

      $tmpArray = array();

      foreach($this->categoryArray as $category) {

        if ($category[$this->parentIdKey] == $currentCategory) {

          array_push($tmpArray,$category); 
 
        } 

      }

      if (count($tmpArray) > 0) {

        foreach($tmpArray as $category) {

          $arraySize = count($sortedArray);

          $sortedArray[$arraySize][$this->nameKey] = $category[$this->nameKey];
          $sortedArray[$arraySize][$this->idKey] = $category[$this->idKey];
          $sortedArray[$arraySize]['level'] = $level;

          echo("in foreach!");

          $sortedArray = $this->makeCategoryTreeArray($sortedArray,$category[$this->idKey],($level+1));

        }

      }

      return $sortedArray;

    }

  }

?>
