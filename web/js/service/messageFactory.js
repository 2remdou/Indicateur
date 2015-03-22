/**
 * Created by mdoutoure on 19/03/2015.
 */
app.factory('messageFactory',[function(){
   var factory = {
       message : false,
       showMessage : false,
       config : function(message){
           factory.message = message;
       }

   } ;
    return factory;
}]);