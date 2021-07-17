/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2021-07-18 00:52:35
 * @modify date 2021-07-18 00:52:35
 * @desc [description]
 */

/**
 * qs = querySelector
 * @param {*} selector 
 */
const qs = (selector) => {
    return d.querySelector(selector)
}

// set global var
const d = document
let resultArea = qs('#result')
let baseurl = qs('script[has-url="true"]').getAttribute('data-baseurl')

// function 

async function openFolder(pathFolder){
    await fetch(`${baseurl}?action=GetDir&path=${pathFolder}`)
    .then(response => response.json())
    .then(result => {
        if (result.length > 0)
        {
            boxTemplateLayout(resultArea, result)
        }
    })
}

function boxTemplateLayout(target, data) {
    let template = `
        <div class="card mx-1 rounded" style="width: 19%; cursor: pointer" data-path="{path}">
            <img class="card-img-top w-25 mt-4 mx-auto block" src="modules/filemanager/assets/{icon}">
            <div class="card-body text-center">
                <span class="block card-title font-weight-bold text-dark text-center">{name}</span>
            </div>
        </div>
    `

    let result = '';
    data.forEach(item => {
        var path = template.replace(/{path}/gi, item.path)
        var icon = path.replace(/{icon}/gi, item.icon)
        var name = icon.replace(/{name}/gi, item.name)
        result += name
    })

    target.innerHTML = result
}