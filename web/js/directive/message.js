/**
 * Created by mdoutoure on 19/03/2015.
 */
app.directive('indMessage',function($rootScope){
    return {
        restrict: 'E',
        templateUrl: 'js/view/message.html',
        scope : {
            showMessage : '=showmessage'
        },
        link: function(scope,element,attris){
            //scope.showMessage = $rootScope.showMessage= false;
            $rootScope.$watch($rootScope.showMessage,function(){
                if($rootScope.showMessage){
                    scope.message = $rootScope.message;
                    scope.typealert = $rootScope.typealert;
                }
               scope.showMessage=$rootScope.showMessage;
            });
        }
    };
});