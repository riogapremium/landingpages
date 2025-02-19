

$(document).ready(function() {


// Form Submit Operations
    var queryString = window.location.search;
    // alert(queryString);
    // Parse the query string into an object
    var params = new URLSearchParams(queryString);

    // Extract the parameters
    var dataShow = params.get('showData');
    var typeofDataForm = params.get('type');
    var tirgplan = params.get('plan');
    var popupopen = 0
    
    $("#utm_source").attr("value",params.get('utm_source'))
    $("#utm_medium").attr("value",params.get('utm_medium'))
    $("#utm_campaign").attr("value",params.get('utm_campaign'))
    $("#utm_term").attr("value",params.get('utm_term'))

    // alert(dataShow)

    // console.log(dataShow)

    if(typeofDataForm == "Check Price" || typeofDataForm == "View Floor Plan" || typeofDataForm == "Download Plans"){
        $(".loadMessage").html("Unveiling latest Plans & Prices just for you<br>Please wait")
    }else if(typeofDataForm == "Download Brochure"){
        $(".loadMessage").html("Request Initiated")
        $(".loadMessage").html("Brochure has been downloaded")

    }else if(typeofDataForm == "Schedule a Site Visit" || typeofDataForm == "Enquire Now"){
        $(".loadMessage").html("Thank you for your enquiry<br>Our Sales Advisor will call you in 30 mins")
    }

    if(dataShow == 'true'){
        // alert();
        // $(".GalleryPopup").after(' <div class="GalleryPopup"><div class="closeGallery"><img loading="lazy" alt="DLF Vistas" src="./img/close2.png" alt=""></div><img loading="lazy" alt="DLF Vistas" src="" id="galImg" /></div>');
        
        $("#aboutDB").attr("href",null)
        $("#aboutDB").attr("download",null)
        $(".dnHeroimageOuter2").removeClass(".dnHeroimageOuter2");

        $("#aboutDB button").html("Brochure Will Be Shared Soon")
        // $(".dnBroBtnOuter .formPopTrigger").removeClass("formPopTrigger")

        // $(".floorplanImg").removeClass("floorplanbackDrop")
        $(".floorplanImg").removeClass("formPopTrigger")

        // Floor Plan Visible
        $(".floorplanbackDrop").addClass("zoomImg")
        $(".floorplanbackDrop").removeClass("floorplanbackDrop")


        // Floorplan still hidden
        // $(".floorplanbackDrop").addClass("floorplanbackDrop2")
        // $(".floorplanbackDrop2").removeClass("floorplanbackDrop")
        // $(".floorplanImg").addClass("zoomImg")


        $(".floorPlanBottom .formPopTrigger").removeClass("formPopTrigger")
        $(".actual_price").each(function(){
            $(this).html($(this).attr("data-checkprice"))
        })
        // $(".starting").removeClass("starting")

        // $(".dnHeroimageOuter").removeClass("videoTigger")
        $(".Highlights iframe").css("pointer-events","unset !important")

        setTimeout(()=>{
            $(".loadingImg").fadeOut();
            // $(".loadingImg").css("top","100%");
        },3000)
        // alert(tirgplan[tirgplan.length -1])

       
        setTimeout(()=>{
            if(tirgplan[tirgplan.length -1] == 2){
                $('.TabBtns[data-showdata="tab2"]').trigger("click")
            }
            $("#tabConfigClick").attr("href","#"+tirgplan)
        },500)

        
        
        setTimeout(()=>{
            $("#tabConfigClick .tabConfigClick").trigger("click")
        },2000)



    }else{

        // $(".loadingImg").css("display","none")

        setTimeout(()=>{
            $(".loadingImg").fadeOut();
            // $(".loadingImg").css("top","-100%");
        },800)

        $("#aboutDB").attr("href",null)
        $("#aboutDB").attr("download",null)

        // setTimeout(()=>{
        //     if(popupopen == 0){
        //         $("#popload").trigger("click");
        //     }
        // },1000)

        
        
        // setTimeout(()=>{
        //     if(popupopen == 0){
        //         $(".usps").css("display","flex")
        //         $("#popload").trigger("click");
        //     }
            
        // },30000)
    }








// Aminities Tabs Start
    $(".imgBtn").parent().click(function(){
        var imgpath = $(this).children(".imgBtn").children("img").attr("src")

        $(".AmiName").html($(this).children(".imgtext").html())

        $("#Aminities #amiImg .swap-not-active").attr("src", imgpath)
        $(".swap-active").fadeOut();
        $(".swap-active").addClass("temp")
        $(".imgBtn").parent().css("pointer-events","none")
       
        setTimeout(function(){
            $(".swap-not-active").addClass("swap-active").removeClass("swap-not-active")
            $(".temp").removeClass("swap-active temp").addClass("swap-not-active")
            $(".swap-active").css("z-index",2)
            $(".swap-not-active").css("z-index",1)
            $("#Aminities #amiImg .swap-not-active").css("display","inline-block")
            $(".imgBtn").parent().css("pointer-events","unset")
        }, 600)
        
        
        // $("#Aminities #amiImg .swap-active").fadeOut()

        // $("#Aminities #amiImg #swapper").attr("id", "frontswapper")
       
        // setTimeout(function(){
        //     $("#Aminities #amiImg img").attr("src", imgpath)
        //     $("#Aminities #amiImg img").fadeIn()
        // }, 500)

        // alert($(this).children(".imgBtn").attr("class"))
    })

    // Aminities Tabs End

    var winHeight = $(window).height();
    var winWidth = $(window).width();
    var about = 0

    $(".banner").click(function(){
        $(this).css("top",-winHeight)
    })

    $("#homenav").click(function(){
        $(".banner").css("top", 0)
    })

    if(winWidth > 600){
        $(".bannerSlider .item").each(function(){
            $(this).css("background-image","url("+$(this).attr("data-imgattr")+")")
        })
    }



    $(window).scroll(function(){
        
        if(winWidth > 500)
        {
            if($(".banner").offset().top - $(window).scrollTop() > -winHeight/2){

           
                $(".bannerShrink").css({
                    // "height": (winHeight+ ($(".banner").offset().top - $(window).scrollTop()/3)),
                        // "width": (winWidth+ ($(".banner").offset().top - $(window).scrollTop()/2)),
                    // "border-radius": ($(".banner").offset().top + $(window).scrollTop())/20
                })
                // console.log($(".banner").offset().top - $(window).scrollTop());
                
            
             }
            //  console.log($(".Highlights .sectitle").offset().top)
        }

        


            // console.log($(".appearText").offset().top - $(window).scrollTop())

            $(".appearText").each(function() {
                if ($(this).offset().top - $(window).scrollTop() < (winHeight)) {
                    // alert()
                    $(this).css({"opacity":"1", "transform":"scale(1)"})
                    
                
                }
            });

            var themeColor =  $("#popload").css("background")
            // $(".AnimatePrice").each(function() {
            //     if ($(this).offset().top - $(window).scrollTop() < (winHeight)) {
                    
            //         $(this).addClass("animateTrigger")
            //         setTimeout(()=>{
            //             $(this).css("background",themeColor)
            //         },2500)
                
                    
                
            //     }
            // });


            if ($("#Aminities").offset().top - $(window).scrollTop() < (winHeight)) {
                // alert()
                
                if(about == 0){
                    $("#popload").trigger("click");
                }
                about = 1
                
                // $(this).css({"opacity":"1", "transform":"scale(1)"})
                
            
            }
      
          
            // $(".Highlights").css("height", ogHeightH + ($(".Highlights .owl-prev").offset().top - $(window).scrollTop()))
      
            
      
            // $(".configuration").css("height", ogHeightC + ($(".configuration .secsubtitle").offset().top - $(window).scrollTop()))
      
            // $(".Aminities").css("height", ogHeightA + ($(".Aminities .displayImage").offset().top - $(window).scrollTop()))

    
    })


//  Config Tabs Function Starts

$(".TabBtns").click(function(){
    $(".TabBtns").removeClass("TabBtns-active")
    $(this).addClass("TabBtns-active")
    $(".hideConfig").hide()
    $("#"+$(this).attr("data-showData")).css("display","inline-flex")
})


// Config Tabs Function Ends

// Connectivity Start

setTimeout(()=>{
    var conWidth = $("#connectLoc").width();
    var locIconWidth = $("#connectLoc .locIcon").width()


    $(".connectLoc").parent().css("width",conWidth)
    $(".locIcon").css("width",locIconWidth)
    // alert(locIconWidth)
    $(".locTabsOuter, .expandConnect").css("width",conWidth)
    // alert(conWidth)

    $(".locTabsOuter").click(function(){
        $(".locTabsOuter").css("pointer-events","none");
        $(".closeExpand").removeClass("active-connect")
        $(this).prev().addClass("active-connect")

        $(".closeExpand").each(function(){
            if(!$(this).hasClass("active-connect")){
                $(this).trigger("click")
            }
        })
       
        
        $(this).prev().show()
        // alert();
        $(this).parent().parent().css("width","50%");
        $(".expandConnect").css("width","100%");
        setTimeout(()=>{
            
            $(this).next().fadeIn()
            
            
        },300)
        setTimeout(()=>{
            
            $(".locTabsOuter").css("pointer-events","unset");
            
        },550)
        
    })
    $(".closeExpand").click(function(){
        $(this).removeClass("active-connect")
        $(this).fadeOut();
        $(this).parent().children(".conContent").hide()
        // $(this).parent().css("width",conWidth)
        // alert($(this).parent().parent().attr("class"));
        $(this).parent().parent().css("width",conWidth)
        setTimeout(()=>{
            
            $(this).parent().css("width",conWidth)
            
        },550)
    
        
    
      
    
    
        })
   
        
        

},800)




    // Connectivity Ends



    // Zoom Image Popup Start

    $(".zoomImg").click(function(){
        // alert();
        var imgData = $(this).children("img").attr("src");
        $(".popupBack").fadeIn();
        $(".GalleryPopup #galImg").attr("src", imgData)
        $(".GalleryPopup").css("transform", "translate(-50%, -50%) scale(1)")

    })

    // Zoom Image Popup Start


    function formatDate(date) {
        var day = ("0" + date.getDate()).slice(-2);
        var month = ("0" + (date.getMonth() + 1)).slice(-2);
        var year = date.getFullYear();
        return year + "-" + month + "-" + day;
      }
  
      // Initialize the datepicker
      $("#sitevisitform").datepicker({
        dateFormat: "dd-mm-yy",
        minDate: 0, // No past dates
        maxDate: "+1M", // Max date 2 months from now
        defaultDate: new Date(), // Default to today
        onSelect: function(dateText, inst) {
          $(this).val(dateText); // Set the value when a date is selected
        }
      });
  
      // Set the default value to today's date
      var today = new Date();
      var formattedToday = formatDate(today);
    //   $("#sitevisitform").val(formattedToday);


// Pop Up Close Code


    var flag = 0; 
    var sitevisite = 0;

    $(".popupBack, .closeGallery, .closeform").click(function(){
        popupopen = 0

        $(".popupBack").fadeOut();
        $(".GalleryPopup").css("transform", "translate(-50%, -50%) scale(0)")
        if(flag=1){
            $("footer").removeClass()
            $("footer").addClass("footerSticky");
            $('footer').hide()
            $('footer').fadeIn();

            var formtype = "Enquire Now"
            $("#typeofForm").attr("value",formtype)
            $(".enqtext").html(formtype)
            if(formtype == "Enquire Now")
                formtype = "Get Instant Call Back"
            
            $("#submitBtn").html(formtype)
            flag=0;

            $("#sitevisitform").hide()
            $("#configDetails").attr("value",'')
        }
        $(".slide-submit button").css("transition","all 400ms ease-out")
        if(winWidth < 600){
            $(".mobileFooter").show()
        }
        
        $(".usps").css("display","none")
       


    })
    


    var getPrice = ''
    var formtypeData 
    var plantrigger = ''

    $(".formPopTrigger").click(function(){
        popupopen = 1

        
        flag = 1;
        var formtype = $(this).html()
        formtypeData = $(this).attr("data-formtype")
        var configDetails = ''
        getPrice = $(this).attr("data-price")
        priceBtn = $(this)

        $("#typeofForm").attr("value",formtype)

        if(formtypeData == "Schedule a Site Visit"){
            $("#sitevisitform").show()
        }
        
        $(".mobileFooter").hide()

        $("#typeofForm").attr("value",formtypeData)
        $(".enqtext").html(formtypeData)
        if(formtype == "Enquire Now")
            formtype = "Get Instant Call Back"
        

         if(formtypeData == "video")
            formtype = "View Video"

        if(formtypeData == "View Floor Plan")
            formtype = "View Floor Plan"

        if(formtypeData == "Check Price" || formtypeData == "View Floor Plan" ){
            configDetails = $(this).attr("data-configdetails")
            plantrigger = $(this).attr("data-redirect")
            // alert($(this).closest("#"+plantrigger).attr("class"))
        }
        
        // console.log(plantrigger)
        // alert($(this).attr("data-configdetails"))

        $("#configDetails").attr("value",configDetails)

        
        $("#submitBtn").html(formtype)

        $(".popupBack").fadeIn();
        // alert();
        $("footer").removeClass()
        
        $("footer").addClass("footerPop");
        $('footer').hide()
        $('footer').fadeIn();

        setTimeout(()=>{
            $(".slide-submit button").css("left","12px")
            // $(".lineswipe").css("left","100%")
            setTimeout(()=>{
                $(".slide-submit button").css("left","0px")
                
                setTimeout(()=>{
                    
                    $(".slide-submit button").css("transition","all 100ms linear")
                },400)
               
            },300)

        },500)
        

    })




    
// For Mobile Devices

if(winWidth < 600){
    setTimeout(()=>{
        $(".offerInner").css("bottom","0%")
    },20)


    $("#sitevisit img").attr("src","./img/calender.gif")
}


// setTimeout(()=>{
//     $(".loadingImg").css("top","100%");
// },1500)

// $("#popload").trigger("click");



   

$(".videoTigger").click(function(){
    $("#popload").trigger("click");
})
    


// on load 
// $(".floorplanbackDrop").click(function(){
//     $("#popload").trigger("click");
// })




// Submit Form Data


let form = document.querySelector("form");

form.addEventListener('submit', (e) => {
    // alert();
    e.preventDefault();
    
    $("#submitBtn").html('Submitting! Please Wait<span class="loading"> <span class="dot">.</span><span class="dot">.</span><span class="dot">.</span></span>');
    $("#submitBtn").css("pointer-events","none");
    var newphone = $(".iti__selected-dial-code").html()+$("#phone").val()
    // alert($("#phone").val())
    $("#phone2").attr("value","'"+newphone.replace(/(?!\+)\s+/g, ''))
    // alert(newphone)
    let data = new FormData(form);
    // console.log(data)
    
    console.log("timer 0");
    fetch('https://script.google.com/macros/s/AKfycbyZZh85c6V3-6wVcYRk2kuTNt2GOd_DZ_5NqlGco-zljNwTZnHIH7pPEV8DWkfnITYIRA/exec', {
        method: "POST",
        body: data,
        
        
    })

    .then(res => res.text())
    .then(responseText => {

        // console.log("First response:", responseText);
        // Handle the response from the first fetch (optional)
        
        console.log("timer 1");
        // Now make a second fetch request to your PHP script to send the email
        let emailData = new FormData();
        emailData.append('name', form.name.value); 
        emailData.append('email', form.email.value);
        emailData.append('country', $(".iti__a11y-text").html());
        emailData.append('phone', form.phone.value);
        emailData.append('type', form.type.value); 
        emailData.append('config', form.config.value || '');
        emailData.append('date', form.date.value || ''); 
        emailData.append('utm_source', form.utm_source.value || ''); 
        emailData.append('utm_medium', form.utm_medium.value || ''); 
        emailData.append('utm_campaign', form.utm_campaign.value || ''); 
        emailData.append('utm_term', form.utm_term.value || ''); 
        emailData.append('project_name', form.project_name.value); 
        console.log("timer 2");
        return fetch('sendmail.php', { // Replace with your PHP email script
            method: 'POST',
            body: emailData
        });
        
    })
    .then(res => res.text())
    .then(emailResponse => {
        // console.log("timer 2");
        // console.log("Email response:", emailResponse);
        // Handle the response from the email sending
        if(formtypeData == "Download Brochure"){
            $("#dbbtn .dbbtn").trigger("click")
        }
        $("#submitBtn").html("Submitted");
        $("#submitBtn").css("pointer-events","unset");
        // Optionally redirect after successful email send
        if($(location).attr("href") == "https://adani-airica-kanjurmarg.com/")
        {
            variques = "?"
        }
        else{
            variques = "&"
        }


        
        window.location.href = "https://adani-airica-kanjurmarg.com?showData=true&type=" + formtypeData + "&plan=" + plantrigger;
    })
    .catch(error => {
        console.error('Error:', error);
        $("#submitBtn").html("Error, try again.");
    });
});



$(".nav-item").click(function(){
    $(".navbar-toggler-icon").trigger("click")
})




$(".nav-item").click(function(){
    $(".navbar-toggler-icon").trigger("click")
})


});
