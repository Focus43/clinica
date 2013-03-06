<?php

	abstract class ClinicaPageController extends Controller {
		
		const PACKAGE_HANDLE	= 'clinica',
			  FLASH_TYPE_OK		= 'success',
			  FLASH_TYPE_ERROR	= 'error';
		
		
		/**
		 * Ruby on Rails "flash" functionality ripoff.
		 * @param string $msg Optional, set the flash message
		 * @param string $type Optional, set the class for the alert
		 * @return void
		 */
		public function flash( $msg = 'Success', $type = self::FLASH_TYPE_OK ){
			$_SESSION['flash_msg'] = array(
				'msg'  => $msg,
				'type' => $type
			);
		}
		
		
		/**
		 * Add js/css + tools URL meta tag; clear the flash.
		 * @return void
		 */
		public function on_start(){
			// header and CSS items
			$this->addHeaderItem( '<meta id="clinicaToolsDir" value="'.CLINICA_TOOLS_URL.'" />' );
			$this->addHeaderItem( $this->getHelper('html')->css('bootstrap.min.css', self::PACKAGE_HANDLE) );
			$this->addHeaderItem( $this->getHelper('html')->css('clinica.app.css', self::PACKAGE_HANDLE) );
			$this->addHeaderItem( $this->getHelper('html')->javascript('libs/modernizr.min.js', self::PACKAGE_HANDLE) );
			
			// ie8 stylesheet
			$ie8 = "<!--[if lt IE 9]>\n" . $this->getHelper('html')->css('ie8.css', self::PACKAGE_HANDLE) . "\n<![endif]-->";
			$this->addHeaderItem( $ie8 );
			
			// footer stuff (usually javascript)
			$this->addFooterItem( $this->getHelper('html')->javascript('libs/bootstrap.min.js', self::PACKAGE_HANDLE) );
			$this->addFooterItem( $this->getHelper('html')->javascript('clinica.app.js', self::PACKAGE_HANDLE) );

			// message flash
			if( isset($_SESSION['flash_msg']) ){
				$this->set('flash', $_SESSION['flash_msg']);
				unset($_SESSION['flash_msg']);
			}
		}
		
		
		/**
		 * Same as $view->action(), but forces to return a fully qualified URL prepended
		 * with https://
		 * @param string $action
		 * @param string $task(s)
		 * @return string
		 */
		public function secureAction($action, $task = null){
			$args = func_get_args();
			array_unshift($args, Page::getCurrentPage()->getCollectionPath());
			$path = call_user_func_array(array('View', 'url'), $args);
			return 'https://' . $_SERVER['HTTP_HOST'] . $path;
		}
		
		
		/**
		 * "Memoize" helpers so they're only loaded once.
		 * @param string $handle Handle of the helper to load
		 * @param string $pkg Package to get the helper from
		 * @return ...Helper class of some sort
		 */
		public function getHelper( $handle, $pkg = false ){
			$helper = '_helper_' . preg_replace("/[^a-zA-Z0-9]+/", "", $handle);
			if( $this->{$helper} === null ){
				$this->{$helper} = Loader::helper($handle, $pkg);
			}
			return $this->{$helper};
		}
		
	}
