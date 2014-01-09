$(function(){
    /**
     * Looks for the tallest height .item, and sets all others to that height. Ensures that the left-float doesn't
     * get all mucked up.
     * @return void
     */
    function normalizeHeights(){
        var $items = $('.item', '#imageSelections').height('auto');
        $items.height((function( _items ){
            var _h = 0;
            for(var i = 0; i < _items.length; i++){
                _h = ( $(_items[i]).height() > _h ) ? $(_items[i]).height() : _h;
            }
            return _h;
        }( $items )));
    }


    /**
     * Make items sortable and initialize tooltips. Should be called after new image are added to ensure always
     * initialized.
     * @return void
     */
    function initInteractions(){
        $('.inner', '#imageSelections').sortable({handle:'.icon-move',items: '.item', cursor: 'move', containment: 'parent', opacity: .65, tolerance: 'pointer'});
    }

    /**
     * Run after new images are added; remove if any duplicates occurred and show the alert
     * message.
     * @return void
     */
    function scanAndPurgeDuplicates(){
        var _list = [], _containsDuplicates = false;
        $('.item', '#imageSelections').each(function(idx, el){
            var $item = $(el), _fileID = $item.attr('data-fileid');
            if( _list.indexOf(_fileID) === -1 ){
                _list.push(_fileID);
            }else{
                _containsDuplicates = true;
                $item.remove();
            }
        });

        if( _containsDuplicates ){
            $('#tabPaneImages').addClass('dups');
        }
    }


    /**
     * Launch the asset manager and select one or more files.
     */
    $('#chooseImg').on('click', function(){
        var _stack = [], _timeOut;
        // Handler function, called once for each image added via custom selection. The setTimeout
        // is used to make sure the function are run only once after this func is called a bunch of times.
        ccm_chooseAsset = function(obj){
            _stack.push(obj);
            clearTimeout(_timeOut);
            _timeOut = setTimeout(function(){
                $.each(_stack, function(idx, obj){
                    $('.inner', '#imageSelections').append('<div class="item" data-fileid="' + obj.fID + '"><i class="icon-minus-sign remover"></i><i class="icon-move"></i><table><tr><td><img src="' + obj.thumbnailLevel1 + '" /><input type="hidden" name="fileIDs[]" value="' + obj.fID + '" /></td></tr></table></div>');
                });
                normalizeHeights();
                initInteractions();
                scanAndPurgeDuplicates();
            }, 250);
        }

        // Launch the file picker.
        ccm_alLaunchSelectorFileManager();
    }).tooltip({animation:false, placement:'bottom'});


    /**
     * Edit the image properties, or remove it?
     */
    $('#imageSelections').on('click', '.item', function( _clickEv ){
        if( $(_clickEv.target).hasClass('remover') ){
            $(this).tooltip('destroy').remove();
        }else{
            $.fn.dialog.open({
                width:  650,
                height: 450,
                title:  'File Properties',
                href:   '/tools/required/files/properties?fID=' + $(this).attr('data-fileid')
            });
        }
    });


    /**
     * Hide the duplicates warning message.
     */
    $('.close', '.dups-warning').on('click', function(){
        $('#tabPaneImages').removeClass('dups');
    });


    /**
     * Tabs
     */
    $('a', '.nav-tabs').on('click', function( _clickEv ){
        var $this = $(this), $targ = $( $this.attr('data-tab') );
        $this.parent('li').add($targ).addClass('active').siblings().removeClass('active');
        // show the Add Images button?
        $('#flexryOptionsRight').toggle( $this.attr('data-tab') === '#tabPaneImages' );
    });


    /**
     * Use original image? (settings area)
     */
    $('#fullUseOriginal').on('change', function(){
        var $this = $(this);
        $('[data-toggle-watch="'+$this.attr('id')+'"]', '#tabPaneSettings').toggle( ! $this.is(':checked') );
    });


    /**
     * File Source dropdown switcher
     */
    $('#fileSourceMethod').on('change', function(){
        var _val = $(this).val(), $btn  = $('#chooseImg');
        $('.fileSourceMethod', '#flexryGallery').removeClass('active').filter('[data-method='+_val+']').addClass('active');
        $btn.toggle( +(_val) === +($btn.attr('data-method')) );
        initHandler();
    });


    /**
     * Template forms selector
     */
    $('#flexryTemplateHandle').on('change', function(){
        var _val = $(this).val();
        $('.template-form', '#tabPaneTemplates').removeClass('active').filter('[data-tmpl="'+_val+'"]').addClass('active');
    });


    /**
     * On init, determine what to run.
     */
    function initHandler(){
        switch( +($('.fileSourceMethod.active').attr('data-method')) ){
            case 0: // custom
                // wait to run normalizeHeights until all the images are done loading in!
                var $images = $('img', '#imageSelections');
                $images.on('load', {count: 0, len: $images.length}, function( _loadEvent ){
                    _loadEvent.data.count++;
                    if( _loadEvent.data.count === _loadEvent.data.len ){
                        normalizeHeights();
                    }
                });
                initInteractions();
                break;

            case 1: // sets
                $('#fileSetPicker').chosen();
                break;
        }
    }


    initHandler();

});