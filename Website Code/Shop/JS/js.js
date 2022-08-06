var images=['img/img1.jpeg', 'img/img2.jpg','img/img3.jpeg','img/img4.jpeg'];

const prev = document.getElementById("prev");
const next = document.getElementById("next");

const img = document.getElementById("slideimg");

const select = document.getElementById("nav-link");
const main = document.getElementById("main");

const rem = document.querySelectorAll('#sus');
const add = document.querySelectorAll('#addq');
const counter = document.querySelectorAll("#counter");
const cart = document.querySelectorAll("#addToCart");

const legend =document.querySelectorAll("#legend");
const pimg = document.querySelectorAll("#img");
const pprice = document.querySelectorAll("#PRICE");

const AvQty = document.querySelectorAll("#availableQty");
const warningQ = document.querySelectorAll("#warning_quantity");

const removeP = document.querySelectorAll("#remP");
const SectionTitle = document.querySelector('#title');
const prodId = document.querySelectorAll('#prodID');
const dis_id = document.querySelector('#discount_id');

var productsArray = [];
var winterArray = [];
var summerArray = [];
var setsArray = [];
var totalArray;

// *********************** DROP DOWN MENU ***********************
select.addEventListener("click",function(){
    if(this.options[this.selectedIndex].value == "Winter")
        location.href="winterSection.php"; 
    else if(this.options[this.selectedIndex].value == "Summer")
            location.href="summerSection.php"
         else if( this.options[this.selectedIndex].value == "Sets")
                location.href="setsSection.php"
});


// ************************************************************

for(let j=0; j < rem.length; j++){
        let q=1;

        rem[j].addEventListener("click", function(){
                if(q>1){
                    q--;
                    counter[j].innerHTML=q; }})

        add[j].addEventListener("click", function(){
                q++;
                counter[j].innerHTML=q;}) 



        cart[j].addEventListener("click",function(){

            
            if( counter[j].innerHTML > parseInt(AvQty[j].innerHTML)){
                warningQ[j].innerHTML="Only "+AvQty[j].innerHTML+" products are available in stock!";
            }
            else{
                warningQ[j].innerHTML="";
                let id = prodId[j].innerText;
                let name = legend[j].innerText;
                let image = pimg[j].src;
                let qty = counter[j].innerText;
                let price = pprice[j].innerText;
                
                var find = false;

                if(SectionTitle.innerHTML == "WINTER COLLECTION"){

                        for( var k=0; k < winterArray.length; k++){

                            // if the item is already in the cart
                            if(winterArray[k].name == name){

                                totQ = parseInt(winterArray[k].qty) + parseInt(qty);

                                // if he add more products than the stock quantity
                                if(counter[j].innerHTML > parseInt(AvQty[j].innerHTML) ){
                                
                                    warningQ[j].innerHTML="Only "+AvQty[j].innerHTML+" products are available in stock!";
                                    find = true;}
                                else{
                                    warningQ[j].innerHTML="";

                                    winterArray[k].qty= totQ;
                                  
                                    document.cookie = 'winterArray='+ JSON.stringify(winterArray);
                                    AvQty[j].innerHTML =  parseInt(AvQty[j].innerHTML) - parseInt(qty);
                                    find = true; }
                        }}
                        
                        if(find == false){
                        
                            var obj = {};
                            obj["id"]=id;
                            obj["name"] = name;
                            obj["image"] = image;
                            obj["price"] = price;
                            obj["qty"] = qty;
                            
                            AvQty[j].innerHTML =  parseInt(AvQty[j].innerHTML) - parseInt(qty);

                            winterArray.push(obj);    
                                   
                            document.cookie = 'winterArray='+ JSON.stringify(winterArray);} 
                            

                        }

                    else if(SectionTitle.innerHTML == "SUMMER COLLECTION"){

                        for( var k=0; k<summerArray.length; k++){

                            // if the item is already in the cart
                            if(summerArray[k].name == name){

                                totQ = parseInt(summerArray[k].qty) + parseInt(qty);

                                // if he add more products than the stock quantity
                                if(counter[j].innerHTML > parseInt(AvQty[j].innerHTML) ){
                                    warningQ[j].innerHTML="Only "+AvQty[j].innerHTML+" products are available in stock!";
                                    find = true;}
                                else{
                                    warningQ[j].innerHTML="";

                                    summerArray[k].qty= totQ;
                                    document.cookie = 'summerArray='+ JSON.stringify(summerArray);
                                    AvQty[j].innerHTML =  parseInt(AvQty[j].innerHTML) - parseInt(qty);
                                    find = true; }
                        }}
                        
                        if(find == false){
                        
                            var obj = {};
                            obj["id"]=id;
                            obj["name"] = name;
                            obj["image"] = image;
                            obj["price"] = price;
                            obj["qty"] = qty;
                            
                            AvQty[j].innerHTML =  parseInt(AvQty[j].innerHTML) - parseInt(qty);
                            
                            summerArray.push(obj); 
                            document.cookie = 'summerArray='+ JSON.stringify(summerArray);}
                        
                        }

                        else if(SectionTitle.innerHTML == "SETS COLLECTION"){

                            for( var k=0; k<setsArray.length; k++){

                                // if the item is already in the cart
                                if(setsArray[k].name == name){

                                    totQ = parseInt(setsArray[k].qty) + parseInt(qty);

                                    // if he add more products than the stock quantity
                                    if(counter[j].innerHTML > parseInt(AvQty[j].innerHTML) ){
                                    
                                        warningQ[j].innerHTML="Only "+AvQty[j].innerHTML+" products are available in stock!";
                                        find = true;}
                                    else{
                                        warningQ[j].innerHTML="";

                                        setsArray[k].qty= totQ;
                                        document.cookie = 'setsArray='+JSON.stringify(setsArray);
                                        AvQty[j].innerHTML =  parseInt(AvQty[j].innerHTML) - parseInt(qty);
                                        find = true; }
                            }}
                            
                            if(find == false){
                            
                                var obj = {};
                                obj["id"]=id;
                                obj["name"] = name;
                                obj["image"] = image;
                                obj["price"] = price;
                                obj["qty"] = qty;
                                
                                AvQty[j].innerHTML =  parseInt(AvQty[j].innerHTML) - parseInt(qty);
                                
                                setsArray.push(obj);
                                document.cookie = 'setsArray='+JSON.stringify(setsArray); }
                            
                            }
                

                q=1;
                counter[j].innerHTML=q;

                
                
                var string1 = getCookie('winterArray');
                if(string1 != null)
                    string1 = string1.substring(1, string1.length - 1); 
                   
                       
                 var string2 = getCookie('summerArray');
                 if(string2 != null)
                     string2 = string2.substring(1, string2.length - 1);

                    
                               
                 var string3 = getCookie('setsArray');
                 if(string3 != null)
                     string3 = string3.substring(1, string3.length - 1);



                
                 if(string1 != null && string2 !=null && string3!=null)
                       totalArray = "".concat("[",string1,",",string2,",",string3,"]"); 
                 else if(string1 != null && string2 ==null && string3==null)
                         totalArray = "".concat("[",string1,"]"); 
                      else if(string1 != null && string2 !=null && string3==null)
                             totalArray = "".concat("[",string1,",",string2,"]");   
                            else if(string1 != null && string2 ==null && string3!=null)
                                     totalArray = "".concat("[",string1,",",string3,"]"); 
                                 else if(string1 == null && string2 !=null && string3==null)
                                          totalArray = "".concat("[",string2,"]");
                                      else if(string1 == null && string2 ==null && string3!=null)
                                          totalArray = "".concat("[",string3,"]");
                
                                         
                 document.cookie = 'prodd='+ totalArray ;     

                  if(qty == 1)
                     swal("1 "+name+" was added to cart successfully", "", "success");
                 else
                     swal(qty+" "+name+" were added to cart successfully", "", "success");

                }

            });
        }

if(SectionTitle.innerHTML == "VICTORIA'S SECRET"){
    document.cookie="winterArray=; expires=Thu, 01 Jan 1970 00:00:00 UTC;";
    document.cookie="summerArray=; expires=Thu, 01 Jan 1970 00:00:00 UTC;";
    document.cookie="setsArray=; expires=Thu, 01 Jan 1970 00:00:00 UTC;";
    document.cookie="prodd=;";
}
    

function getCookie(cName) { 
    const name = cName + "="; 
    const cDecoded = decodeURIComponent(document.cookie); 
    const cArr = cDecoded.split('; '); 
    let res; 
    cArr.forEach(val => { 
        if (val.indexOf(name) === 0) res = val.substring(name.length); }) 
        return res }  

// ************************* SLIDER ***********************************

let i=0;

next.addEventListener("click",function(){
    i++;
    if(i==images.length)
        {i=0;
         img.src=images[i];}
    else {
        img.src=images[i];
    }
    
   
});

prev.addEventListener("click",function(){
    i--;
    if(i<0){
        i=images.length - 1;
        img.src=images[i];
    }
    else{
        img.src=images[i];
    }  
});

