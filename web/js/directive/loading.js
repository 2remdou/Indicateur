/**
 * Created by delphinsagno on 18/03/15.
 */

app.directive('indLoading',function($rootScope){
   return {
       restrict : 'EA',
       templateUrl: 'js/view/loading.html',
       transclude : true,
       scope : {
       },
       link : function(scope,element,attribs){
           scope.loading=$rootScope.loading;
           scope.$on('onLoading',function(e){
              scope.loading=false;
           });
       }

   } ;
});