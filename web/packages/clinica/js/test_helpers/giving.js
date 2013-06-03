    
    $(function(){
        
        var TestHelper = new function(){
            
            function randomString( _length, numericOnly ){
                var text        = "",
                    possible    = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
                    
                if( numericOnly === true ){ possible = "0123456789"; }
                
                for( var i=0; i < _length; i++ ){
                    text += possible.charAt(Math.floor(Math.random() * possible.length));
                }
                return text;
            }
            
            
            this.autofill = function(){
                // autofill everything first, then do specific field overrides
                $('input', 'form').each(function(idx, el){
                    $(el).val( randomString(10) )
                });
                
                $('[placeholder="Patient Birth Date"]').val('04/17/1986');
                $('[name="state"]').val('MD');
                $('[name="zip"]').val( randomString(5, true) );
                $('[name="amount"]').val( randomString(3, true) );
                $('[name="card_number"]').val('6011000000000012');
                $('[name="card_type"]').val('visa');
                $('[name="exp_month"]').val('9');
                $('[name="exp_year"]').val('2014');
                
                return this;
            }
            
            
            this.send = function(){
                $('#frmGiving').submit();
                
                return this;
            }
            
        }
        
        window.TestHelper = TestHelper;
        
    });
