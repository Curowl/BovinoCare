import moment  from 'moment-timezone'



const categoryCard = document.querySelectorAll('.category-card')
const modalCategory= document.querySelector('.category-detail-modal')

if(categoryCard){
    categoryCard.forEach((item)=>{
        item.addEventListener('click', (e)=>{
            // console.log(e.delegateTarget.children[0].children[0].value)
            const uuid = e.delegateTarget.children[0].children[0].value
            getCategoryDetail(uuid)
        })
    })
}

async function getCategoryDetail(uuid) {
    try {
        const response = await axios.get('/category/'+uuid);
        // console.log(response);
        // console.log(response.data.created_at == response.data.updated_at);
        displayIntoModal(uuid, response.data.name, response.data.description, response.data.created_at, response.data.updated_at, response.data.budget)
    } catch (error) {
        console.error(error);
    }
}

function displayIntoModal(uuid, name, description, created_at , updated_at, budget) {
    const searchParams = new URLSearchParams(window.location.search);
    let sort        = searchParams.get('sortAlphabetic') ? searchParams.get('sortAlphabetic') : 'asc'
    let dateStart   = searchParams.get('dateStart') ? searchParams.get('dateStart') : ''
    let dateEnd     = searchParams.get('dateEnd') ? searchParams.get('dateEnd') : ''

    const page = searchParams.get('page') ? searchParams.get('page') : 1

    if(modalCategory){
        modalCategory.children[0].children[0].innerHTML = name
        modalCategory.children[1].innerHTML = description
        modalCategory.children[2].children[0].innerHTML = updated_at === created_at ? 
                                                            'Created at '+moment(created_at).tz('Asia/Jakarta').format('LLL')
                                                            : 
                                                            'Created at '+moment(created_at).tz('Asia/Jakarta').format('LLL')+'<br> Updated at '+moment(updated_at).tz('Asia/Jakarta').format('LLL') 
        modalCategory.children[3].children[1].setAttribute('href', '/category/'+uuid+'/detail?page='+page+'&sortAlphabetic='+sort+'&dateStart='+dateStart+'&dateEnd='+dateEnd)
        modalCategory.children[3].children[2].setAttribute('href', '/category/'+uuid+'/edit?page='+page+'&sortAlphabetic='+sort+'&dateStart='+dateStart+'&dateEnd='+dateEnd)
        modalCategory.children[3].children[3].setAttribute('href', '/category/'+uuid+'/delete?page='+page+'&sortAlphabetic='+sort+'&dateStart='+dateStart+'&dateEnd='+dateEnd)
       
        let li = document.createElement('li')
        let a = document.createElement('a')
        if(budget.length > 0){
            budget.forEach(element => {
                a.classList.add('dropdown-item')
                a.setAttribute('href', '/budget/'+element.uuid)
                a.innerHTML = element.title.slice(0, 15)
                li.appendChild(a)
                if(modalCategory.children[3].children[0].children[1].children.length > 0){
                    for(let item = 0; item < modalCategory.children[3].children[0].children[1].children.length; item++){
                        modalCategory.children[3].children[0].children[1].children[item].remove()
                    }
                    modalCategory.children[3].children[0].children[1].appendChild(li)
                }else{
                    modalCategory.children[3].children[0].children[1].appendChild(li)
                }
            })
        }else{
            a.classList.add('dropdown-item')
            a.setAttribute('href', 'javascript:void(0)')
            a.innerHTML = 'No budget for this category'
            li.appendChild(a)
            if(modalCategory.children[3].children[0].children[1].children.length > 0){
                for(let item = 0; item < modalCategory.children[3].children[0].children[1].children.length; item++){
                    modalCategory.children[3].children[0].children[1].children[item].remove()
                }
                modalCategory.children[3].children[0].children[1].appendChild(li)
            }else{
                modalCategory.children[3].children[0].children[1].appendChild(li)
            }
        }
    }
}
