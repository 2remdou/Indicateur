/**
 * Created by delphinsagno on 29/03/15.
 */
app.directive('datepicker',function(){
   return {
      restrict : 'C',
       require : 'ngModel',
       link: function(scope,element,attribs,ngModelCtrl){
           $(element).datepicker({
               changeMonth: true,
               changeYear : true,
               dateFormat: "yy-mm-dd",
               onSelect:function (date) {
                   var d = moment(date).format('YYYY-MM-DD[T]HH:mm:ssZZ');
                   ngModelCtrl.$setViewValue(d);
                   scope.$apply();

               }
           });
       }
   } ;
});