<?
defined('C5_EXECUTE') or die("Access Denied.");

Loader::model('attribute/types/default/controller');

class TextAttributeTypeController extends Concrete5_Controller_AttributeType_Text  {
	
	public function paymentForm() {
		if (is_object($this->attributeValue)) {
			$value = Loader::helper('text')->entities($this->getAttributeValue()->getValue());
		}
		print Loader::helper('form')->text($this->field('value'), $value, array('class' => 'input-block-level', 'placeholder' => $this->getAttributeKey()->getAttributeKeyName()));
	}
	
}