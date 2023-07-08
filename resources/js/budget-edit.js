const list          = document.querySelector('#money-container')
const btnAdd        = document.querySelector('#add-more-money')
const inputAmount   = document.querySelector('#amount')
const btnSubmit     = document.querySelector('#submit')

let historyAmount   = 0
btnAdd.addEventListener('click', (e)=>{
    e.preventDefault()
    dynamicElement()
    e.target.disabled = true
})

const getBudgetingHistory = async (uuid) =>{
    try {
        const response = await axios.get('/budget/history/'+uuid);
        // console.log(response)
        if(response.data.budget){
            if(response.data.budget.budget_detail.length > 0){
                response.data.budget.budget_detail.forEach(element => {
                    dynamicElement(element.amount)
                    historyAmount+=parseInt(element.amount)
                    if(historyAmount > parseInt(inputAmount.value)){
                        btnAdd.disabled = true
                    }
                });
            }
        }
    } catch (error) {
        console.error(error);
    }
}

const dynamicElement = (amount = null) =>{
    let row         = document.createElement('div')
    let col         = document.createElement('div')
    let inputGroup  = document.createElement('div')
    let span        = document.createElement('span')
    let input       = document.createElement('input')
    let btn         = document.createElement('button')

    row.classList.add('row')
    row.classList.add('mb-2')

    col.classList.add('col')
    col.classList.add('d-flex')
    
    inputGroup.classList.add('input-group')
    span.classList.add('input-group-text')
    span.innerHTML = "Rp"
    input.setAttribute('type', 'number')
    input.setAttribute('class', 'form-control')
    input.setAttribute('name', 'budgetHistory[]')
    let total = 0
    input.addEventListener('input', (e)=>{  
        if(e.target.value){
           
            total = parseInt(e.target.value)  + historyAmount

            if(total > parseInt(inputAmount.value)){
                if(list.lastChild.children.length == 1){
                    removeWarning()

                    let invalidDiv = document.createElement('div')
                    invalidDiv.classList.add('invalid-feedback')
                    invalidDiv.innerHTML = "Cannot larger than maximum amount"
                    list.lastChild.children[0].children[0].appendChild(invalidDiv)
                    list.lastChild.children[0].children[0].children[1].classList.add('is-invalid')
                    btnSubmit.disabled = true
                }
            }else{
                removeWarning()
            }
        }
    })

    btn.innerHTML = "X"
    btn.classList.add('btn')
    btn.classList.add('btn-outline-danger')
    btn.classList.add('btn-sm')
    btn.classList.add('ms-3')
    btn.classList.add('remove-money')
    btn.addEventListener('click', (removeBtn)=> {
        removeBtn.preventDefault()
        removeBtn.target.parentElement.parentElement.remove()
        btnAdd.disabled = false
    })
    
    if(amount){
        input.value = amount
        input.disabled = true
    }

    inputGroup.appendChild(span)
    inputGroup.appendChild(input)
    col.appendChild(inputGroup)
    if(amount == null){
        col.appendChild(btn)
    }
    row.appendChild(col)
    
    list.appendChild(row)
}

const uuid = window.location.pathname.split('/')
getBudgetingHistory(uuid[2])

const removeWarning = ()=>{
    if(list.lastChild.lastChild.children[0].children.length > 1){
        for(let index = 0; index < list.lastChild.lastChild.children[0].children.length; index++){
            if(index>1){
                list.lastChild.children[0].children[0].children[index].remove()
                list.lastChild.children[0].children[0].children[1].classList.remove('is-invalid')
            }
        }
    }
    btnSubmit.disabled = false
}