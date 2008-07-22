function Ajax()
{
     this.requestObj = null;

     this.construct = function ()
     {
          if (window.XMLHttpRequest)
          {
               return new XMLHttpRequest;
          }
          else if (window.ActiveXObject)
          {
               return new ActiveXObject("Microsoft.XMLHTTP");
          }
          else return null;
     }

     this.getReadyStateHandler = function (req, handler, params)
     {
        return function ()
        {
           handler(req, params);
        }
     }

     this.sendRequest = function (url, params, method, myFunc)
     {
          this.requestObj = this.construct();
          if (!this.requestObj) return false;

          if (!method || !method.length || method.length < 3) method = "POST";

          this.requestObj.onreadystatechange = this.getReadyStateHandler(this.requestObj, myFunc, this.parseParams(params));

          this.requestObj.open(method,url,true);
          this.requestObj.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
          this.requestObj.send(params);
     }


     this.parseParams = function(str)
     {
       var vals   = str.split('&');
       var pers   = new Array;
       var mas    = new Object;
       var newstr = 'mas = {';
       for (var i = 0; i < vals.length; i++)
       {
         pers = vals[i].split('=');
         newstr += pers[0]+':"'+ pers[1]+'"';
         if(vals[i+1]) newstr += ',';
       }
       newstr += '}';
       return eval(newstr);
     }

     this.getText = function(reg)
     {
       return reg.responseText;
     }

     this.getXML = function(reg)
     {
       return reg.responseXML;
     }

     this.construct();
}