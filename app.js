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
const ds = qs('script[has-url="true"]').getAttribute('data-ds')
let resultArea = qs('#result')
let baseurl = qs('script[has-url="true"]').getAttribute('data-baseurl')

// function 

async function openFolder(pathFolder){
    if (pathFolder === 'root')
    {
        location.reload()
        return
    }

    if (qs('.actionArea').classList.contains('d-none'))
    {
        qs('.actionArea').classList.remove('d-none')
    }

    pathFolder = trimDs(pathFolder.replace(/^(?:\.\.\/)+/, ""))

    
    if (pathFolder !== '')
    {
        await fetch(`${baseurl}?action=GetDir&path=${pathFolder}`)
        .then(response => response.json())
        .then(result => {
            if (result.length > 0)
            {
                qs('.pathName').innerHTML = 'Folder ' + pathFolder
                boxTemplateLayout(resultArea, result)
                let slicePath = splitPerDs(pathFolder)
                qs('#back-btn').setAttribute('to', (slicePath.length === 1) ? 'root' : getUpDir(slicePath))
            }
            else
            {
                toastr.error('Error wa', 'Galat')
            }
        })
    }
}

function backPage(el)
{
    openFolder(el.getAttribute('to'))
}

function splitPerDs(string)
{
    let spliceString;
    switch (ds) {
        case "/":
            spliceString = string.split(/\//)
            break;
    
        case "\\":
            spliceString = string.split(/\\/)
            break;
    }
    
    return spliceString
}

function trimDs(string)
{
    let trim;
    switch (ds) {
        case "/":
            trim = string.replace(/^\/|\/$/g, '')
            break;
    
        case "\\":
            trim = string.replace(/^\\|\\$/g, '')
            break;
    }

    return trim
}

function getUpDir(slicePath)
{
    let fixPath = ''
    for (let idx = 0; idx < (slicePath.length - 1); idx++) {
        if (slicePath[idx] !== '')
        {
            fixPath += slicePath[idx] + ds;
        }
    }
    
    return trimDs(fixPath)
}

function boxTemplateLayout(target, data) {
    let template = `
        <div class="card mx-1 rounded" style="width: 19%; cursor: pointer">
            <input type="checkbox" class="checkItem mx-2 my-3" data-path="{path}"/>
            <img class="card-img-top w-25 mt-4 mx-auto block" src="modules/filemanager/assets/{icon}" onclick="openFolder('{path}')">
            <div class="card-body text-center">
                <span class="block card-title font-weight-bold text-dark text-center" onclick="openRename(this)">{name}</span>
                <input type="text" value="{name}" onblur="renameName(this)" class="d-none"/>
            </div>
        </div>
    `

    let result = '';
    data.forEach(item => {
        var path = template
        if (item.type !== 'directory')
        {
          var path = path.replace('onclick', 'takColokKoe')
        }
        
        var path = path.replace(/{path}/gi, item.path)
        var icon = path.replace(/{icon}/gi, item.icon)
        var name = icon.replace(/{name}/gi, item.name)
        result += name
    })

    target.innerHTML = result
}

function openRename(el)
{
    el.classList.add('d-none')
    qs(`input[value="${el.innerHTML}"]`).classList.remove('d-none')
}

async function renameName(el)
{
    await fetch(`${baseurl}`, {
        method: 'PATCH',
        body: JSON.stringify({test:true})
    })
    .then(response => response.text())
    .then(result => {
        console.log(result)
    })
}