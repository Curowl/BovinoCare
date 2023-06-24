const amount        = document.querySelector('#amount')
const firstMoney    = document.querySelector('#first-money')

let eventFirstMoney = null

firstMoney.addEventListener('input', (fm)=>{
    // console.log(fm.target.value, amount.value)
    eventFirstMoney = fm
    let first       = parseInt(fm.target.value)
    let max         = parseInt(amount.value)
    if(amount.value){
        displayErrorMessage(first, max, fm)
    }
})

amount.addEventListener('input', (a)=>{
    let first   = parseInt(firstMoney.value)
    let max     = parseInt(a.target.value)
    if(firstMoney.value && eventFirstMoney){
        displayErrorMessage(first, max, eventFirstMoney)
    }
})

 /*
    the input amount and firstmoney need custom validation (not just bootstrap validation : required/not reqired), so here we go : 

    using function called setCustomValidity('your error messaage')
    that function caming from htmlspec (THE WORLD STANDARD of HTML Document)
    see the their doc about setCustomValidity() here : https://html.spec.whatwg.org/multipage/form-control-infrastructure.html#the-constraint-validation-api
*/
const displayErrorMessage = (first, max, element)=>{
    // console.log(element, first, max)
    if(first > max ){
        firstMoney.parentElement.children[2].style.display = 'block'
        firstMoney.parentElement.children[1].classList.add('is-invalid')
        element.target.setCustomValidity('it is wrong')
     }else{
        firstMoney.parentElement.children[2].style.display = 'none'
        firstMoney.parentElement.children[1].classList.remove('is-invalid')
        element.target.setCustomValidity('') // leave the param with empty string
     }
}