/**
 * Created by delphinsagno on 21/03/15.
 */

app.directive('indDeleteModal',[function(){
    return {
        restrict : 'A',
        templateUrl : 'js/view/deleteModal.html',
        scope : {

        },
        transclude : true,
        link : function(scope,element,attribs){
            element.on('click',function(e){
                $(element).find('.modal').modal();
            });
        }
    };
}]);