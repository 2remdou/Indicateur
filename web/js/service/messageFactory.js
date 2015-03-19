/**
 * Created by mdoutoure on 19/03/2015.
 */
app.factory('messageFactory',function(){
   var factory = {
       message : false,
       typealert : false,
       config : function(message,typealert){
           factory.message=message;
           factory.typealert=typealert;
       },
       getMessage : function(){
           return factory.message;
       },
       getTypeAlert : function(){
           return factory.typealert;
       }

   } ;
    return factory;
});