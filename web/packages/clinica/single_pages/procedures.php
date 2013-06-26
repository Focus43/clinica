<?php defined('C5_EXECUTE') or die("Access Denied."); ?>

<div class="container-fluid" style="padding:0;">
    <div class="row-fluid">
        <div class="span12">
            <table id="procedureTable" class="table table-bordered">
                <tr>
                    <td>
                        <form style="margin:0;" id="frmAuthorize" method="post" action="<?php echo $this->controller->secureAction('authorize'); ?>">
                            <p class="centerize">Authorization is required to view the procedures table. Please enter your password:</p>
                            <p class="centerize"><input name="password" type="password" placeholder="Password" style="margin:0;" /> <button class="btn" type="submit">Authorize</button></p>
                        </form>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function(){
        /**
         * Two-step process to access the data. Makes one ajax call to validate password,
         * and is sent back the actual URI and a token to make the next request if the user
         * is valid and has access.
         */
        $('#frmAuthorize').ajaxifyForm({
            showFeedback: false
        }).on('ajaxify_complete', function(_event, respData){
            if( respData.code === 1 ){
                var _uri = respData.uri + respData.token;
                $.get(_uri, function(_html){
                    $('#procedureTable').empty().append(_html);
                }, 'html');
            }else{
                alert(respData.messages[0]);
            }
        });
    });
</script>