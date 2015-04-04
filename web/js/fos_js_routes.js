fos.Router.setData({"base_url":"","routes":{"indexhomepage":{"tokens":[["variable",".","json|xml|html","_format"],["text","\/"]],"defaults":{"_format":"json"},"requirements":{"_method":"GET","_format":"json|xml|html"},"hosttokens":[]},"get_unite":{"tokens":[["variable",".","json|xml|html","_format"],["variable","\/","[^\/\\.]++","id"],["text","\/unites"]],"defaults":{"_format":"json"},"requirements":{"_method":"GET","_format":"json|xml|html"},"hosttokens":[]},"get_unites":{"tokens":[["variable",".","json|xml|html","_format"],["text","\/unites"]],"defaults":{"_format":"json"},"requirements":{"_method":"GET","_format":"json|xml|html"},"hosttokens":[]},"post_unite":{"tokens":[["variable",".","json|xml|html","_format"],["text","\/unites"]],"defaults":{"_format":"json"},"requirements":{"_method":"POST","_format":"json|xml|html"},"hosttokens":[]},"put_unite":{"tokens":[["variable",".","json|xml|html","_format"],["variable","\/","[^\/\\.]++","unite"],["text","\/unites"]],"defaults":{"_format":"json"},"requirements":{"_method":"PUT","_format":"json|xml|html"},"hosttokens":[]},"delete_unite":{"tokens":[["variable",".","json|xml|html","_format"],["variable","\/","[^\/\\.]++","unite"],["text","\/unites"]],"defaults":{"_format":"json"},"requirements":{"_method":"DELETE","_format":"json|xml|html"},"hosttokens":[]},"get_hote":{"tokens":[["variable",".","json|xml|html","_format"],["variable","\/","[^\/\\.]++","id"],["text","\/hotes"]],"defaults":{"_format":"json"},"requirements":{"_method":"GET","_format":"json|xml|html"},"hosttokens":[]},"get_hotes":{"tokens":[["variable",".","json|xml|html","_format"],["text","\/hotes"]],"defaults":{"_format":"json"},"requirements":{"_method":"GET","_format":"json|xml|html"},"hosttokens":[]},"post_hote":{"tokens":[["variable",".","json|xml|html","_format"],["text","\/hotes"]],"defaults":{"_format":"json"},"requirements":{"_method":"POST","_format":"json|xml|html"},"hosttokens":[]},"put_hote":{"tokens":[["variable",".","json|xml|html","_format"],["variable","\/","[^\/\\.]++","hote"],["text","\/hotes"]],"defaults":{"_format":"json"},"requirements":{"_method":"PUT","_format":"json|xml|html"},"hosttokens":[]},"delete_hote":{"tokens":[["variable",".","json|xml|html","_format"],["variable","\/","[^\/\\.]++","hote"],["text","\/hotes"]],"defaults":{"_format":"json"},"requirements":{"_method":"DELETE","_format":"json|xml|html"},"hosttokens":[]},"get_type_indicateur":{"tokens":[["variable",".","json|xml|html","_format"],["text","\/type-indicateur\/{$id}"]],"defaults":{"_format":"json"},"requirements":{"_method":"GET","_format":"json|xml|html"},"hosttokens":[]},"get_type_indicateurs":{"tokens":[["variable",".","json|xml|html","_format"],["text","\/type-indicateurs"]],"defaults":{"_format":"json"},"requirements":{"_method":"GET","_format":"json|xml|html"},"hosttokens":[]},"post_type_indicateur":{"tokens":[["variable",".","json|xml|html","_format"],["text","\/type-indicateurs"]],"defaults":{"_format":"json"},"requirements":{"_method":"POST","_format":"json|xml|html"},"hosttokens":[]},"put_type_indicateur":{"tokens":[["variable",".","json|xml|html","_format"],["variable","\/","[^\/\\.]++","typeIndicateur"],["text","\/type-indicateurs"]],"defaults":{"_format":"json"},"requirements":{"_method":"PUT","_format":"json|xml|html"},"hosttokens":[]},"delete_type_indicateur":{"tokens":[["variable",".","json|xml|html","_format"],["variable","\/","[^\/\\.]++","typeIndicateur"],["text","\/type-indicateurs"]],"defaults":{"_format":"json"},"requirements":{"_method":"DELETE","_format":"json|xml|html"},"hosttokens":[]},"get_indicateurs":{"tokens":[["variable",".","json|xml|html","_format"],["text","\/indicateurs"]],"defaults":{"_format":"json"},"requirements":{"_method":"GET","_format":"json|xml|html"},"hosttokens":[]},"get_indicateur":{"tokens":[["variable",".","json|xml|html","_format"],["variable","\/","[^\/\\.]++","id"],["text","\/indicateurs"]],"defaults":{"_format":"json"},"requirements":{"_method":"GET","_format":"json|xml|html"},"hosttokens":[]},"post_indicateur":{"tokens":[["variable",".","json|xml|html","_format"],["text","\/indicateurs"],["variable","\/","[^\/]++","hote"],["text","\/hotes"],["variable","\/","[^\/]++","typeIndicateur"],["text","\/type-indicateurs"]],"defaults":{"_format":"json"},"requirements":{"_method":"POST","_format":"json|xml|html"},"hosttokens":[]},"put_indicateur":{"tokens":[["variable",".","json|xml|html","_format"],["variable","\/","[^\/\\.]++","indicateur"],["text","\/indicateurs"]],"defaults":{"_format":"json"},"requirements":{"_method":"PUT","_format":"json|xml|html"},"hosttokens":[]},"delete_indicateur":{"tokens":[["variable",".","json|xml|html","_format"],["variable","\/","[^\/\\.]++","indicateur"],["text","\/indicateurs"]],"defaults":{"_format":"json"},"requirements":{"_method":"DELETE","_format":"json|xml|html"},"hosttokens":[]},"get_detail_indicateur":{"tokens":[["variable",".","json|xml|html","_format"],["variable","\/","[^\/\\.]++","id"],["text","\/details"]],"defaults":{"_format":"json"},"requirements":{"_method":"GET","_format":"json|xml|html"},"hosttokens":[]},"get_detail_indicateurs":{"tokens":[["variable",".","json|xml|html","_format"],["text","\/details"]],"defaults":{"_format":"json"},"requirements":{"_method":"GET","_format":"json|xml|html"},"hosttokens":[]},"get_detail_by_indicateurs":{"tokens":[["variable",".","json|xml|html","_format"],["text","\/details"],["variable","\/","[^\/]++","indicateur"],["text","\/indicateurs"]],"defaults":{"_format":"json"},"requirements":{"_method":"GET","_format":"json|xml|html"},"hosttokens":[]},"get_detail_by_unites":{"tokens":[["variable",".","json|xml|html","_format"],["text","\/details"],["variable","\/","[^\/]++","unite"],["text","\/unites"]],"defaults":{"_format":"json"},"requirements":{"_method":"GET","_format":"json|xml|html"},"hosttokens":[]},"get_detail_by_unite_and_by_indicateur":{"tokens":[["variable",".","json|xml|html","_format"],["text","\/details"],["variable","\/","[^\/]++","indicateur"],["text","\/indicateurs"],["variable","\/","[^\/]++","unite"],["text","\/unites"]],"defaults":{"_format":"json"},"requirements":{"_method":"GET","_format":"json|xml|html"},"hosttokens":[]},"post_detail_indicateur":{"tokens":[["variable",".","json|xml|html","_format"],["text","\/details"],["variable","\/","[^\/]++","indicateur"],["text","\/indicateurs"],["variable","\/","[^\/]++","unite"],["text","\/unites"]],"defaults":{"_format":"json"},"requirements":{"_method":"POST","_format":"json|xml|html"},"hosttokens":[]},"put_detail_indicateur":{"tokens":[["variable",".","json|xml|html","_format"],["variable","\/","[^\/\\.]++","detailIndicateur"],["text","\/details"]],"defaults":{"_format":"json"},"requirements":{"_method":"PUT","_format":"json|xml|html"},"hosttokens":[]},"delete_detail_indicateur":{"tokens":[["variable",".","json|xml|html","_format"],["variable","\/","[^\/\\.]++","detailIndicateur"],["text","\/details"]],"defaults":{"_format":"json"},"requirements":{"_method":"DELETE","_format":"json|xml|html"},"hosttokens":[]}},"prefix":"","host":"localhost","scheme":"http"});