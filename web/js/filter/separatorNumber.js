/**
 * Created by mdoutoure on 01/04/2015.
 */
app.filter('separatorNumber',function(){
    return function(input){
        if(input)
         return input.replace(/,/g,' ');
    }
});
