/**
 * Created by mdoutoure on 19/03/2015.
 */
app.directive('indMessage',['messageFactory',function(){
    return {
        restrict: 'E',
        templateUrl: 'js/view/message.html',
        scope : {

        },
        link : function(scope,element,attribs){
            scope.$on('showMessage',function(e,args){
                scope.showMessage = true;
                scope.messages = args.messages;
                scope.typeAlert = args.typeAlert;
            });
            scope.$on('hideMessage',function(){
                scope.showMessage = false;
            });

        }
    };
}]);