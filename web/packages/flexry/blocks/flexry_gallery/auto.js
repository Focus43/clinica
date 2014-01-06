$(function(){
    /**
     * Looks for the tallest height .item, and sets all others to that height. Ensures that the left-float doesn't
     * get all mucked up.
     * @return void
     */
    function normalizeHeights(){
        var $items = $('.item', '#imageSelections');
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
     * Run after new images are added; determines if duplicates have been added and will
     * show the alert message.
     * @return void
     */
    function scanDuplicates(){
        var _dups = false,
            _list  = [];
        $('.item', '#imageSelections').each(function(idx, el){
            var $item = $(el), _fileID = $item.attr('data-fileid');
            if( _list.indexOf(_fileID) === -1 ){
                _list.push(_fileID);
            }else{
                _dups = true;
            }
        });

        if( _dups ){ $('#tab-choose-images').addClass('dups'); }
    }

    /**
     * Launch the asset manager and select one or more files.
     */
    $('#chooseImg').on('click', function(){
        var _stack = [], _timeOut;
        // This function is the handler for once the file(s) are selected in the file manager. This function gets
        // called once for every file object chosen.
        ccm_chooseAsset = function(obj){
            _stack.push(obj);
            clearTimeout(_timeOut);
            _timeOut = setTimeout(function(){
                $.each(_stack, function(idx, obj){
                    $('.inner', '#imageSelections').append('<div class="item" data-fileid="' + obj.fID + '"><i class="icon-minus-sign remover"></i><i class="icon-move"></i><table><tr><td><img src="' + obj.thumbnailLevel1 + '" /><input type="hidden" name="fileIDs[]" value="' + obj.fID + '" /></td></tr></table></div>');
                });
                normalizeHeights();
                initInteractions();
                scanDuplicates();
            }, 250);
        }

        // Launch the file picker.
        ccm_alLaunchSelectorFileManager();
    }).tooltip({animation:false, placement:'bottom'});

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
     * If user clicks on Eliminate Duplicates; do it...
     */
    $('#eliminateDups').on('click', function(){
        var _list = [];
        $('.item', '#imageSelections').each(function(idx, el){
            var $item = $(el), _fileID = $item.attr('data-fileid');
            if( _list.indexOf(_fileID) === -1 ){
                _list.push(_fileID);
            }else{
                $item.remove();
            }
        });

        $('#tab-choose-images').removeClass('dups');
    });

    /**
     * User chose not to eliminate duplicates and close the warning.
     */
    $('.close', '.dups-warning').on('click', function(){
        $('#tab-choose-images').removeClass('dups');
    });

    /**
     * Tabs
     */
    $('a', '.nav-tabs').on('click', function( _clickEv ){
        var $this = $(this),
            $targ = $( $this.attr('data-tab') );
        $this.parent('li').add($targ).addClass('active').siblings().removeClass('active');
        // show the Add Images button?
        $('#chooseImg').toggle( $this.attr('data-tab') === '#tab-choose-images' );
    });

    // gets called automatically on initialization for .items that already exist.
    normalizeHeights();
    initInteractions();
});