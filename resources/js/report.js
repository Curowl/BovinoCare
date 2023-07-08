import Tags from 'bootstrap5-tags'
import Chart from 'chart.js/auto'


const last10BudgetReach100  = document.querySelector('#last-10-budget-reach-100')
const last10BudgetReach50   = document.querySelector('#last-10-budget-reach-50')
const mostChoosenCategory   = document.querySelector('#most-choosen-category')

const element = (h6, a) =>{
    let col         = document.createElement('div')
    let card        = document.createElement('div')
    let cardBody    = document.createElement('div')
    let cardText    = document.createElement('h6')
    let cardFooter  = document.createElement('a')
    
    col.classList.add('col')
    card.classList.add('card')
    card.classList.add('h-100')
    cardBody.classList.add('card-body')
    cardBody.classList.add('p-2')
    cardText.classList.add('card-text')
    cardText.innerHTML = h6
    cardFooter.innerHTML = 'see detail'
    cardFooter.setAttribute('href', a)
    cardFooter.classList.add('btn')
    cardFooter.classList.add('card-footer')
    cardFooter.classList.add('p-1')
    
    cardBody.appendChild(cardText)
    card.appendChild(cardBody)
    card.appendChild(cardFooter)
    col.appendChild(card)

    return col
}


const getBudgetReach100 = async () => {
    try {
        const responseReach100 = await axios.get('/report/last-10-budget-reach-100')
        // console.log(responseReach100)
        if(responseReach100.data.budget.length > 0){
            responseReach100.data.budget.forEach((el)=>{
                last10BudgetReach100.appendChild(element(el.title.substr(0, 30), '/budget/'+el.uuid))
            })
        }

    } catch (error) {
        console.error(error)
    }
}

const getBudgetReach50 = async ()=>{
    try {
        const responseReach50 = await axios.get('/report/last-10-budget-reach-50')
        // console.log(responseReach50)
        if(responseReach50.data.budget.length > 0){
            responseReach50.data.budget.forEach((el)=>{
                last10BudgetReach50.appendChild(element(el.title.substr(0, 30), '/budget/'+el.uuid))
            })
        }
    } catch (error) {
        console.error(error)
    }
}

const getMostChoosenCategory = async ()=>{
    try {
        const responseMostChoosenCategory = await axios.get('/report/most-choosen-category')
        // console.log(responseMostChoosenCategory)
        if(responseMostChoosenCategory.data.category.length > 0){
            responseMostChoosenCategory.data.category.forEach((el)=>{
                mostChoosenCategory.appendChild(element(el.name.substr(0, 30), '/category/'+el.uuid+'/detail'))
            })
        }
    } catch (error) {
        console.error(error)
    }
}

const categoryContainer = document.querySelector('#categoriesContainer')
let theSelectTagsItself = null
const selectElement = (options) =>{
    let div     = document.createElement('div')
    let select  = document.createElement('select')
    let invalid = document.createElement('div')
    let optionDummy = document.createElement('option')

    select.classList.add('form-select')
    select.setAttribute('multiple', 'multiple')
    select.setAttribute('data-allow-clear', 'true')

    invalid.classList.add('invalid-feedback')
    invalid.innerHTML = 'Please select a valid tag.'
   
    optionDummy.setAttribute('selected', 'selected')
    optionDummy.setAttribute('disabled', 'disabled')
    optionDummy.setAttribute('hidden', 'hidden')
    optionDummy.setAttribute('value', '')
    optionDummy.innerHTML = 'Choose a tag...'
    select.appendChild(optionDummy)
    options.map((el)=>{
        let option  = document.createElement('option')
        option.setAttribute('value', el.uuid)
        option.innerHTML = el.name
        select.appendChild(option)
    })
    div.appendChild(select)
    div.appendChild(invalid)
    theSelectTagsItself = new Tags(select)

    return div
}

const getAllCategory = async ()=>{
    try {
        const responseAllCategory = await axios.get('/all/category')
        categoryContainer.appendChild(selectElement(responseAllCategory.data))
    } catch (error) {
        console.error(error)
    }
}

getBudgetReach100()
getBudgetReach50()
getMostChoosenCategory()
getAllCategory()

const generateGraphic  = async (categories)=>{
    try{
        console.log(categories)
        let myLabels  = []
        let array   = []
        for(let item in categories.categories){
            array.push(item)
        }

        let data = (el) =>{
            let dataArray = []
            for(let item in el){
                myLabels.push(item)
                dataArray.push({year:item, count:el[item]})
            }
            return dataArray
        }

        let myDatasets = []
        let i = 0;
        for(let item in categories.categories){
            myDatasets.push(
                {
                    label: item,
                    data: data(categories.categories[array[i]]).map(row => row.count)
                }
            )
            i++
        }

        let uniqLabels = [...new Set(myLabels)]
        new Chart(
            document.getElementById('report-canvas'),
            {
              type: 'line',
              data: {
                labels: uniqLabels,
                datasets: myDatasets
              }
            }
        )
    }catch (error){
        console.log(error)
    }
}

let getCategoryCompare = async(dateStart, dateEnd) =>{
    try {
        const responsCategory = await axios.get('/report/compare-category',{
            params: {
              categoryUuids : theSelectTagsItself.getSelectedValues(),
              dateStart     : dateStart,
              dateEnd       : dateEnd
            }
          })
        generateGraphic(responsCategory.data)
    } catch (error) {
        console.error(error)
    }
}

const filterCategory    = document.querySelector('#filterCategory')
const canvasReport      = document.querySelector('#canvasReportContainer')
filterCategory.addEventListener('click', ()=>{
    let dateStart   = document.querySelector('#dateStartCompare').value
    let dateEnd     = document.querySelector('#dateEndCompare').value
    if(theSelectTagsItself 
        && theSelectTagsItself.getSelectedValues().length > 0
        && dateStart
        && dateEnd){
            if(canvasReport.children.length > 0){
                canvasReport.children[0].remove()

                let canvas = document.createElement('canvas')
                canvas.setAttribute('id', 'report-canvas')
                canvasReport.appendChild(canvas)
            }
            getCategoryCompare(dateStart, dateEnd)
    }
})