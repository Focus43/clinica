<? defined('C5_EXECUTE') or die("Access Denied.");

	class ValidationFormHelper extends Concrete5_Helper_Validation_Form {
		
		protected $attributeKeysToValidate = array(),
		          $requiredMinimums        = array();
		
		
		public function addRequiredAttribute( AttributeKey $akObj, $errorMsg = null ){
			$this->attributeKeysToValidate[] = (object) array(
				'akObj' 	=> $akObj,
				'message'	=> $errorMsg
			);
		}
        
        
        public function addRequiredMinimum( $field, $minValue, $message = 'Minimum amount not met.' ){
            $this->requiredMinimums[] = (object) array(
                'field'     => $field,
                'minValue'  => $minValue,
                'message'   => $message
            );
        }
		
		
		public function test(){
			$stringsVal = Loader::helper('validation/strings');
            
            // validate minimum number fields
            if( !empty($this->requiredMinimums) ){
                foreach($this->requiredMinimums AS $obj){
                    // test
                    if( !((int)$this->data[$obj->field] >= (int)$obj->minValue) ){
                        $this->error->add($obj->message);
                    }
                }
            }
            
            // validate attribute key fields
			if( !empty($this->attributeKeysToValidate) ){
				foreach($this->attributeKeysToValidate AS $akObjContainer){
					$formValue = $this->data['akID'][$akObjContainer->akObj->getAttributeKeyID()]['value'];
					if( !$stringsVal->notempty($formValue) ){
						$errorMsg = !is_null($akObjContainer->message) ? $akObjContainer->message : 'Missing required field ' . $akObjContainer->akObj->akName;
						$this->error->add($errorMsg);
					}
				}
			}

			return parent::test();
		}
		
	}