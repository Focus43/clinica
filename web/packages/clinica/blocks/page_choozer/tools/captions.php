<?php

	if( isset($_REQUEST['blockID']) ){
		try {
			$blockObj = Block::getByID( (int)$_REQUEST['blockID'] );
			
			// is it a valid block object?
			if( $blockObj instanceof Block ){
				$blockInstance = $blockObj->getInstance();
				
				// when we get the block instance, is *it* valid?
				if( $blockInstance instanceof HtmlFiveVideoBlockController){
					echo $blockInstance->captions;
				}
			}
		}catch(Exception $e){
			// do nothing
		}
	}
