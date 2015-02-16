<?php defined('C5_EXECUTE') or die("Access Denied."); ?>

<style type="text/css">
    #procedureTable tr td, #procedureTable tr th {white-space:nowrap;}
    #procedureTable tr td:last-child {width:99%;}
    #procedureTable .procedure-form {display:block;}
    #procedureTable .procedure-form img {display:inline-block;max-height:50px;margin-right:5px;}
</style>

<div class="container-fluid" style="padding:0;">
    <div class="row-fluid">
        <div class="span12">
            <table id="procedureTable" class="table table-bordered">
                <tr>
                    <td>Loading procedure table...</td>
                </tr>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function(){
        $.get('<?php echo $this->action('get_data', $accessToken); ?>', function( _html ){
            $('#procedureTable').empty().append(_html);
        }, 'html');
    });
</script>