/**
 * Created by delphinsagno on 18/03/15.
 */

app.directive('indLoading',function($rootScope){
   return {
       restrict : 'EA',
       templateUrl: 'js/view/loading.html',
       transclude : true,
       scope : {
           loading : "=valeurLoading"
       },
       link : function(scope,element,attribs){
           $rootScope.$watch($rootScope.loading,function(){
               scope.loading=$rootScope.loading;
           });
       }

   } ;
});