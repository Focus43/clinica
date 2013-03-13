<? defined('C5_EXECUTE') or die("Access Denied.");

	class ValidationFormHelper extends Concrete5_Helper_Validation_Form {
		
		protected $attributeKeysToValidate = array();
		
		
		public function addRequiredAttribute( AttributeKey $akObj, $errorMsg = null ){
			$this->attributeKeysToValidate[] = (object) array(
				'akObj' 	=> $akObj,
				'message'	=> $errorMsg
			);
		}
		
		
		public function test(){
			$stringsVal = Loader::helper('validation/strings');
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