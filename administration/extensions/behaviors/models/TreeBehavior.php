<?php

class TreeBehavior extends CActiveRecordBehavior
{
	public $id='id';
	public $parent_id='parent_id';
	public $left='lft';
	public $right='rgt';
	public $level='level';
	public $name='name';

	public $isAllowedManyRoots=false;

	//rebuildTree
	public function rebuildTree($parent_id=0, $left=0) {
		$owner=$this->getOwner();

		$right = $left+1;
        // get all children of this node
        $tableName=$owner->tableName();
        $rows=$owner->getDbConnection()->createCommand("SELECT `{$this->id}` FROM `{$tableName}` WHERE `{$this->parent_id}`={$parent_id}")->queryColumn();
        foreach ($rows as $id) {
        	// recursive execution of this function for each
        	// child of this node
        	// $right is the current right value, which is
        	// incremented by the rebuildTree function
        	$right = $this->rebuildTree($id, $right);
        }
        // we've got the left value, and now that we've processed
        // the children of this node we also know the right value
        $owner->getDbConnection()->createCommand("UPDATE `{$tableName}` SET `{$this->left}`={$left},`{$this->right}`={$right} WHERE `{$this->id}`=$parent_id")->execute();
        // return the right value of this node + 1
        return $right + 1;
	}
	//update level
	public function rebuildTreeLevel() {
		$owner=$this->getOwner();
		$tableName=$owner->tableName();
		$rows=$owner->getDbConnection()->createCommand("SELECT `{$this->id}`,`{$this->left}`,`{$this->right}` FROM `{$tableName}` ORDER BY `{$this->left}`")->queryAll();
		foreach ($rows as $row) {
			$level=$owner->getDbConnection()->createCommand("SELECT COUNT(*) FROM `{$tableName}` WHERE `{$this->left}`<={$row[$this->left]} AND `{$this->right}`>{$row[$this->right]}")->queryScalar();
        	$owner->getDbConnection()->createCommand("UPDATE `{$tableName}` SET `{$this->level}`={$level} WHERE `{$this->id}`={$row[$this->id]}")->execute();
		}
	}
	
	public function initTree($name="__ROOT__") {
		$owner=$this->getOwner();
		$tableName=$owner->tableName();
		//清空数据
		$owner->getDbConnection()->createCommand("TRUNCATE TABLE `{$tableName}`")->execute();
		//初始化根
		$owner->setIsNewRecord(true);
		$owner->setAttribute($this->id,false);
		$owner->setAttribute($this->name,$name);
		$owner->setAttribute($this->parent_id,0);
		$owner->save();
		//$owner->getDbConnection()->createCommand("INSERT INTO `{$tableName}` (`{$this->parent_id}`,`{$this->left}`,`{$this->right}`,`{$this->level}`,`{$this->name}`) VALUES (0,1,2,0,'{$name}') ")->execute();
	}

	public function beforeSave($event) {
		$owner=$this->getOwner();

		if ($owner->getIsNewRecord()) {//if create
			$parent_id=$owner->getAttribute($this->parent_id);
			if ($parent_id) {
				$parent=$owner->find("$this->id = '$parent_id'");
				if ($parent===null) {
					$owner->addError($this->parent_id,'Parent node not exist');
					$event->isValid=false;
				} else {
					// update left and right values
					$owner->updateAll(array($this->left=>new CDbExpression("$this->left + 2")),"`$this->left` >= '{$parent->getAttribute($this->right)}'");
					$owner->updateAll(array($this->right=>new CDbExpression("$this->right + 2")),"`$this->right` >= '{$parent->getAttribute($this->right)}'");
					//set values
					$owner->setAttribute($this->level,$parent->getAttribute($this->level)+1);
					$owner->setAttribute($this->left,$parent->getAttribute($this->right));
					$owner->setAttribute($this->right,$parent->getAttribute($this->right)+1);
				}
			} else {
				if ($this->isAllowedManyRoots===false && $owner->count("$this->parent_id = 0")) {
					$owner->addError($this->parent_id,'Only allowed one root node');
					$event->isValid=false;
				} else {
					$tableName=$owner->tableName();
					$maxRight=$owner->getDbConnection()->createCommand("SELECT MAX($this->right) FROM $tableName")->queryScalar();

					$owner->setAttribute($this->level,0);
					$owner->setAttribute($this->left,$maxRight+1);
					$owner->setAttribute($this->right,$maxRight+2);
				}
			}
		} else {//if update
			//remain old data
			$old=$owner->find("`$this->id` = '".$owner->getAttribute($this->id)."'");
			if ($owner->getAttribute($this->parent_id) != $owner->getAttribute($this->id) && $owner->getAttribute($this->parent_id) != $old->getAttribute($this->parent_id)) {//改变父节点时
				if ($this->isAllowedManyRoots===false && $old->getAttribute($this->parent_id) && !$owner->getAttribute($this->parent_id)) {
					$owner->addError($this->parent_id,'Only allowed one root node');
					$event->isValid=false;
				} else {
					$parent=$owner->find("$this->id = '".$owner->getAttribute($this->parent_id)."'");
					if ($parent===null) {
						$owner->addError($this->parent_id,'Parent node not exist');
						$event->isValid=false;
					} elseif ($owner->getAttribute($this->left)<$parent->getAttribute($this->left) && $owner->getAttribute($this->right)>$parent->getAttribute($this->right)) {
						$owner->addError($this->parent_id,'Parent node not allowed,because this node is your children');
						$event->isValid=false;
					} else {
						//原来的父节点
						$oldParent=$owner->find("$this->id = '".$old->getAttribute($this->parent_id)."'");
						//level的偏移量
						$lvl=$parent->getAttribute($this->level)-$oldParent->getAttribute($this->level);
						//当前节点的所有子节点(包含当前节点);
						$nodeChildren=$owner->findAll("$this->left>={$owner->getAttribute($this->left)} AND $this->right<={$owner->getAttribute($this->right)}");
						$nodeChildrenIds=array();
						foreach ($nodeChildren as $row) {
							$nodeChildrenIds[]=$row->id;
						}
						$nodeChildrenIds=implode(',',$nodeChildrenIds);
						$value=$owner->getAttribute($this->right)-$owner->getAttribute($this->left);
						
						if ($parent->getAttribute($this->right)>$owner->getAttribute($this->right)) {
							$owner->updateAll(array($this->left=>new CDbExpression("$this->left-$value-1")),"$this->left>{$owner->getAttribute($this->right)} AND $this->right<={$parent->getAttribute($this->right)}");
							$owner->updateAll(array($this->right=>new CDbExpression("$this->right-$value-1")),"$this->right>{$owner->getAttribute($this->right)} AND $this->right<{$parent->getAttribute($this->right)}");
							$value=$parent->getAttribute($this->right)-$owner->getAttribute($this->right)-1;
							$owner->updateAll(array($this->left=>new CDbExpression("$this->left+$value"),$this->right=>new CDbExpression("$this->right+$value"),$this->level=>new CDbExpression("$this->level+$lvl")),"$this->id IN ($nodeChildrenIds)");
						} else {
							//更新左值
							$owner->updateAll(array($this->left=>new CDbExpression("$this->left+$value+1")),"$this->left>{$parent->getAttribute($this->right)} AND $this->left<{$owner->getAttribute($this->left)}");
							//更新右值
							$owner->updateAll(array($this->right=>new CDbExpression("$this->right+$value+1")),"$this->right>={$parent->getAttribute($this->right)} AND $this->right<{$owner->getAttribute($this->left)}");
							//更新自己以及子类
							$value=$owner->getAttribute($this->left)-$parent->getAttribute($this->right);
							$owner->updateAll(array($this->left=>new CDbExpression("$this->left-$value"),$this->right=>new CDbExpression("$this->right-$value"),$this->level=>new CDbExpression("$this->level+$lvl")),"$this->id IN ($nodeChildrenIds)");
						}
						$node=$owner->findByPk($owner->getAttribute($this->id));
						$owner->setAttribute($this->level,$node->getAttribute($this->level));
						$owner->setAttribute($this->left,$node->getAttribute($this->left));
						$owner->setAttribute($this->right,$node->getAttribute($this->right));
					}
				}
			}
		}
	}

	public function afterDelete($event) {
		$owner=$this->getOwner();

		$left=$owner->getAttribute($this->left);
		$right=$owner->getAttribute($this->right);
		$span=$right-$left+1;
		$owner->deleteAll("$this->left > '$left' AND $this->right < '$right'");
        $owner->updateAll(array($this->left=>new CDbExpression("$this->left - {$span}")),"$this->left > $right");
        $owner->updateAll(array($this->right=>new CDbExpression("$this->right - {$span}")),"$this->right > $right");
	}

	//根据主键获取当前节点
	public function node($id=null) {
		$owner=$this->getOwner();
		if ($id===null) {
			$condition="$this->parent_id = 0";
		} else {
			$condition="$this->id = '$id'";
		}
		return $owner->find($condition);
	}

	//获取所有根节点
	//$force是否强制显示根,
	public function roots($force=false) {
		$owner=$this->getOwner();

		$criteria=new CDbCriteria;
		$criteria->order=$this->left." ASC";
		$criteria->condition="$this->parent_id = 0";
		if ($force===true || $this->isAllowedManyRoots===true) {
			$roots=$owner->findAll($criteria);
			if (!$roots && $force===true) {//自动创建一个根
				$this->initTree();
				return $this->roots($force);
			}
			return $owner->findAll($criteria);
		} else {
			$root=$owner->find($criteria);
			if ($root) {
				$criteria->condition="$this->parent_id = '{$root->getAttribute($this->id)}'";
				return $owner->findAll($criteria);
			} else {
				return array();
			}
		}
	}

	//$force是否强制显示根,
	public function items($force=true) {
		$owner=$this->getOwner();

		$criteria=new CDbCriteria;
		$criteria->order=$this->left." ASC";
		if ($force===false) {
			$criteria->condition="$this->parent_id <> 0";
		}
		$rows=$owner->findAll($criteria);
    	$listData=array();
    	foreach ($rows as $row) {
    		$listData[$row->getAttribute($this->id)]='|'.str_repeat('-',$row->getAttribute($this->level)).$row->getAttribute($this->name);
    	}
        return $listData;
	}

    public function treeList() {
        return $this->items();
    }

	//获取从该节点到根节点的路径
	public function getPath($showRoot=true) {
		$owner=$this->getOwner();

		$criteria=new CDbCriteria;
		$criteria->order=$this->left." ASC";
		$criteria->condition="$this->left < '{$owner->getAttribute($this->left)}' AND $this->right > '{$owner->getAttribute($this->right)}'";
		if ($showRoot===false) {
			$criteria->addCondition("$this->parent_id <> 0");
		}
		return $owner->findAll($criteria);
	}

	//获取父节点
	public function getParent() {
		$owner=$this->getOwner();
		return $owner->find("$this->id = {$owner->getAttribute($this->parent_id)}");
	}

	public function getPrev() {
		$owner=$this->getOwner();
		return $owner->find("$this->right = ".($owner->getAttribute($this->left)-1));
	}

	public function getNext() {
		$owner=$this->getOwner();
		return $owner->find("$this->left = ".($owner->getAttribute($this->right)+1));
	}



	//获取子节点
	public function getChildren($direct = true) {
		$owner=$this->getOwner();

		$criteria=new CDbCriteria;
		$criteria->order=$this->left." ASC";

		if ($direct===true) {
			$criteria->condition="$this->parent_id = '{$owner->getAttribute($this->id)}'";
		} else {
			$criteria->condition="$this->left > '{$owner->getAttribute($this->left)}' AND $this->right < '{$owner->getAttribute($this->right)}'";
		}

		return $owner->findAll($criteria);
	}

	public function getChildrenIds() {
		$owner=$this->getOwner();

		$tableName=$owner->tableName();
		return $owner->getDbConnection()->createCommand("SELECT id FROM $tableName WHERE $this->left >= '{$owner->getAttribute($this->left)}' AND $this->right <= '{$owner->getAttribute($this->right)}'")->queryColumn();
	}

	public function getHasChildren() {
		$owner=$this->getOwner();
		return $owner->getAttribute($this->right)-$owner->getAttribute($this->left)>1;
	}

	public function moveUp() {
		$owner=$this->getOwner();

		if ($owner->getAttribute($this->parent_id)) {
			$parent=$owner->find("$this->id = '{$owner->getAttribute($this->parent_id)}'");
			if ($parent===null) {
				$owner->addError($this->parent_id,'找不到父类，可能该树已损坏');
				return false;
			}
			if ($owner->getAttribute($this->left)-$parent->getAttribute($this->left)<=1) {
				$owner->addError($this->parent_id,'已经置顶，无法再往上移');
				return false;
			}
		} elseif ($this->isAllowedManyRoots===false) {
			$owner->addError($this->parent_id,'根节点无法移动');
			return false;
		}

		$prev=$this->getPrev();
		if ($prev===null) {
			$owner->addError($this->parent_id,'前面已经没有节点，无法再往上移');
			return false;
		} else {
			$tableName=$owner->tableName();
			$maxRight=$owner->getDbConnection()->createCommand("SELECT MAX($this->right) FROM $tableName")->queryScalar();
			$shift=$maxRight-$prev->getAttribute($this->left)+1;
			$owner->updateAll(array($this->right=>new CDbExpression("$this->right + $shift")),"$this->right BETWEEN {$prev->getAttribute($this->left)} AND {$prev->getAttribute($this->right)}");
			$owner->updateAll(array($this->left=>new CDbExpression("$this->left + $shift")),"$this->left BETWEEN {$prev->getAttribute($this->left)} AND {$prev->getAttribute($this->right)}");

			$shift=$owner->getAttribute($this->left)-$prev->getAttribute($this->left);
			$owner->updateAll(array($this->right=>new CDbExpression("$this->right - $shift")),"$this->right BETWEEN {$owner->getAttribute($this->left)} AND {$owner->getAttribute($this->right)}");
			$owner->updateAll(array($this->left=>new CDbExpression("$this->left - $shift")),"$this->left BETWEEN {$owner->getAttribute($this->left)} AND {$owner->getAttribute($this->right)}");

			$shift=$maxRight-$prev->getAttribute($this->left)-($owner->getAttribute($this->right)-$owner->getAttribute($this->left));
			$owner->updateAll(array($this->right=>new CDbExpression("$this->right - $shift")),"$this->right > $maxRight");
			$owner->updateAll(array($this->left=>new CDbExpression("$this->left - $shift")),"$this->left > $maxRight");
		}
		return true;
	}


	public function moveDown() {
		$owner=$this->getOwner();

		if ($owner->getAttribute($this->parent_id)) {
			$parent=$owner->find("$this->id = '{$owner->getAttribute($this->parent_id)}'");
			if ($parent===null) {
				$owner->addError($this->parent_id,'找不到父类，可能该树已损坏');
				return false;
			}
			if ($parent->getAttribute($this->right)-$owner->getAttribute($this->right)<=1) {
				$owner->addError($this->parent_id,'已经置底，无法再往下移');
				return false;
			}
		} elseif ($this->isAllowedManyRoots===false) {
			$owner->addError($this->parent_id,'根节点无法移动');
			return false;
		}

		$next=$this->getNext();
		if ($next===null) {
			$owner->addError($this->parent_id,'后面已经没有节点，无法再往下移');
			return false;
		} else {
			$tableName=$owner->tableName();
			$maxRight=$owner->getDbConnection()->createCommand("SELECT MAX($this->right) FROM $tableName")->queryScalar();
			$shift=$maxRight-$owner->getAttribute($this->left)+1;
			$owner->updateAll(array($this->right=>new CDbExpression("$this->right + $shift")),"$this->right BETWEEN {$owner->getAttribute($this->left)} AND {$owner->getAttribute($this->right)}");
			$owner->updateAll(array($this->left=>new CDbExpression("$this->left + $shift")),"$this->left BETWEEN {$owner->getAttribute($this->left)} AND {$owner->getAttribute($this->right)}");

			$shift=$next->getAttribute($this->left)-$owner->getAttribute($this->left);
			$owner->updateAll(array($this->right=>new CDbExpression("$this->right - $shift")),"$this->right BETWEEN {$next->getAttribute($this->left)} AND {$next->getAttribute($this->right)}");
			$owner->updateAll(array($this->left=>new CDbExpression("$this->left - $shift")),"$this->left BETWEEN {$next->getAttribute($this->left)} AND {$next->getAttribute($this->right)}");

			$shift=$maxRight-$owner->getAttribute($this->left)-($next->getAttribute($this->right)-$next->getAttribute($this->left));
			$owner->updateAll(array($this->right=>new CDbExpression("$this->right - $shift")),"$this->right > $maxRight");
			$owner->updateAll(array($this->left=>new CDbExpression("$this->left - $shift")),"$this->left > $maxRight");
		}
		return true;
	}


}