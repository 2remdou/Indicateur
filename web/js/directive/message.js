/**
 * Created by mdoutoure on 19/03/2015.
 */
app.directive('indMessage',function($rootScope){
    return {
        restrict: 'E',
        templateUrl: 'js/view/message.html',
        scope : {
        },
        link: function(scope,element,attris){
            scope.message = $rootScope.message.message;
            scope.typealert = $rootScope.message.typealert;
            scope.$on('onShowMessage',function(){
                scope.showMessage=true;
            });
        }
    };
});