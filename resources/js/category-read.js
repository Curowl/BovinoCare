import moment  from 'moment-timezone'



const categoryCard = document.querySelectorAll('.category-card')
const modalCategory= document.querySelector('.modal-content')

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
        displayIntoModal(uuid, response.data.name, response.data.description, response.data.created_at, response.data.updated_at)
    } catch (error) {
        console.error(error);
    }
}

function displayIntoModal(uuid, name, description, created_at , updated_at) {
    const searchParams = new URLSearchParams(window.location.search);
    const page = searchParams.get('page') ? searchParams.get('page') : 1

    if(modalCategory){
        modalCategory.children[0].children[0].innerHTML = name
        modalCategory.children[1].innerHTML = description
        modalCategory.children[2].children[0].innerHTML = updated_at === created_at ? 
                                                            'Created at '+moment(created_at).tz('Asia/Jakarta').format('LLL')
                                                            : 
                                                            'Created at '+moment(created_at).tz('Asia/Jakarta').format('LLL')+'<br> Updated at '+moment(updated_at).tz('Asia/Jakarta').format('LLL') 
        modalCategory.children[3].children[1].setAttribute('href', '/category/'+uuid+'/edit?page='+page)
        modalCategory.children[3].children[2].setAttribute('href', '/category/'+uuid+'/delete?page='+page)
    }
}
