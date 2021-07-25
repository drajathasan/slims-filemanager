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
                <span class="block card-title font-weight-bold text-dark text-center filelabel" onclick="openRename(this, {num})">{name}</span>
                <input type="text" value="{name}" label-for="{num}" orig-value="{name}" onkeypress="enterToRename(event, this, '{path}')" onblur="renameName(this, '{path}')" class="d-none"/>
            </div>
        </div>
    `

    let result = '';
    data.forEach((item,idx) => {
        var path = template
        if (item.type !== 'directory')
        {
          var path = path.replace('onclick', 'takColokKoe')
        }
        
        var path = path.replace(/{path}/gi, item.path)
        var icon = path.replace(/{icon}/gi, item.icon)
        var name = icon.replace(/{name}/gi, item.name)
        var num = name.replace(/{num}/gi, idx)
        result += num
    })

    target.innerHTML = result
}

function openRename(el, idx)
{
    el.setAttribute('style', 'display: none !important')
    qs(`input[label-for="${idx}"]`).classList.remove('d-none')
}

async function renameName(el, path)
{
    let oldName = el.getAttribute('orig-value')
    let newName = el.value
    
    if (newName !== oldName)
    {
        await fetch(`${baseurl}`, {
            method: 'PATCH',
            body: JSON.stringify({newFile: newName, oldFile: oldName, srcPath: path})
        })
        .then(response => response.json())
        .then(result => {
            // check status
            if (result.status)
            {
                // set dom action
                el.classList.add('d-none')
                el.setAttribute('orig-value', el.value)
                el.parentNode.children[0].innerHTML = el.value
                el.parentNode.children[0].removeAttribute('style')
                toastr.success(result.msg, 'Sukses')
            }
            else
            {
                toastr.error(result.msg, 'Galat')
            }
        })
        .catch(error => {
            toastr.error('Ada keasalahan pada server.', 'Galat')
        })   
    }
    else
    {
        el.classList.add('d-none')
        el.parentNode.children[0].removeAttribute('style')
    }
}

function enterToRename(e, obj, path)
{
    if (e.key === 'Enter')
    {
        renameName(obj, path)
    }
}