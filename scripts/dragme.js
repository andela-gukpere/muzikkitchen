    var offx = 0, offy = 0;
    function element(e)
    {
         e = e?e:window.event;
        this.x = e.pageX?e.pageX:e.clientX;
        this.y = e.pageY?e.pageY:e.clientY;
        this.id = (e.target?e.target:e.srcElement).parentNode.parentNode;
     }
     
      function drag(e)
    {
        var m = new element(e);
        offx = m.x - parseInt(m.id.style.left);
		offy = m.y - parseInt(m.id.style.top);
        addL("mousemove",mmouse);
        addL("mouseup",rmouse);
    }
    function opacOn(m)
    {
        m.style.filter = "opacity:30";
        m.style.filter = "Alpha(opacity = 30)";
        m.style.opacity = "0.3"; 
    }
    function opacff(m)
    {
         m.style.filter = "Alpha(opacity = 100)";          
         m.style.filter = "opacity:100";
         m.style.opacity = "1";     
    }
    function mmouse(e)
    {
        e = new element(e);						
        var x = e.x - offx;
        var y = e.y - offy;
        try
        {
          e.id.style.left = x + "px";
          e.id.style.top = y + "px";

         // opacOn(e.id);
        }
        catch(e2)
        {
        
        }
    }
    function rmouse(e)
    {
        e = new element(e);
        remL("mousemove",mmouse);
        remL("mouseup",rmouse);
       // opacff(e.id);
    }
    function addL(ev,func)
    {
        document.attachEvent?document.attachEvent("on"+ev,func,false):document.addEventListener(ev,func,false);
    }
    function remL(ev,func)
    {
           document.detachEvent?document.detachEvent("on"+ev,func,false):document.removeEventListener(ev,func,false);
    }