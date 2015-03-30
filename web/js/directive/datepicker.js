/**
 * Created by delphinsagno on 29/03/15.
 */
app.directive('datepicker',function(){
   return {
      restrict : 'C',
       link: function(scope,element,attribs){
           $(element).datepicker();
       }
   } ;
});