var electron = require('electron');  
var {app, BrowserWindow, Menu, ipcMain} = electron;  
var mainWindow = null;
var retstr = "";

var imga = "";
var imgb = "";

const fs = require('fs');

  const template = [
    {
      label: 'Edit',
      submenu: [
        {label: 'Annotate',
        click()  {     mainWindow.loadURL(`file://${__dirname}/example/example.html`);
//    mainWindow.openDevTools() 
        }},
      ]},
      {
      label: 'new win',
      submenu: [
          {
          label:'display',
          click() {
            mainWindow.loadURL(`file://${__dirname}/index.html`);
        }
        }
      ]
    },
    
  ]
  
  if (process.platform === 'darwin') {
    template.unshift({
      label: app.getName(),
      submenu: [
        {role: 'about'},
        {type: 'separator'},
        {role: 'services', submenu: []},
        {type: 'separator'},
        {role: 'hide'},
        {role: 'hideothers'},
        {role: 'unhide'},
        {type: 'separator'},
        {role: 'quit'}
      ]
    })
  
    // Edit menu
    template[1].submenu.push(
      {type: 'separator'},
      {
        label: 'Speech',
        submenu: [
          {role: 'startspeaking'},
          {role: 'stopspeaking'}
        ]
      }
    )
  
    // Window menu
    template[3].submenu = [
      {role: 'close'},
      {role: 'minimize'},
      {role: 'zoom'},
      {type: 'separator'},
      {role: 'front'}
    ]
  }
  
  const menu = Menu.buildFromTemplate(template)
  Menu.setApplicationMenu(menu)
myarr = new Array()
expertarr = new Array()

idx=0
app.on('ready', () => {  
    mainWindow = new BrowserWindow({
        width: 1280,
        height: 768,
        show:false
    });
  // create a new `splash`-Window 
  splash = new BrowserWindow({width: 380, height: 400, transparent: true, frame: false, alwaysOnTop: true});
  splash.loadURL(`file://${__dirname}/splash.html`);
  setTimeout(function2, 3000);
  mainWindow.loadURL(`file://${__dirname}/startpage/index.html`);
  
  // if main window is ready to show, then destroy the splash window and show up the main window

    addToList()
//      mainWindow.openDevTools()
});

function function2 ()
{
        splash.destroy();
        mainWindow.show();
}

function getindexof (name)
{
    var mind
    for (n=0;n<idx;n++)
    {
        if (expertarr[n][1]==name)
        {   
            mind = n;
            break;
        }
    }
    return mind;
}

function update()
{
     
    if (getindexof(imga) > getindexof(imgb))
    {
        top = mainWindow
        let win = new BrowserWindow({ modal: true, parent: top, width: 800, height: 600})
        win.on('closed', () => {
          win = null
        })
        
        // Or load a local HTML file
        win.loadURL(`file://${__dirname}/error.html`)
        updateImage();
    }
    else
    {
        top = mainWindow
        let win = new BrowserWindow({ modal: true, parent: top, width: 800, height: 600})
        win.on('closed', () => {
          win = null
        })
        
  
        // Or load a local HTML file
        win.loadURL(`file://${__dirname}/correct.html`)
        updateImage();
    }
    if (getindexof(imga) >= getindexof(imgb))
    {
//            alert ("updating")
        myarr[getindexof(imga)][0] = myarr[getindexof(imgb)][0]+0.5
        myarr = myarr.sort(function (a,b){return b[0] - a[0]})
/*            temparr = new Array()*/
        for (n=0;n<myarr.length;n++)
        {
            myarr[n][0] = myarr.length - n
        }
//            temparr = temparr.sort(function (a,b){return b[0] - a[0]})
//            myarr = temparr.slice()
    }
    for (tn=0;tn<idx; tn++)
        console.log (myarr[tn])   
}

function addToList()
{

    var lineReader = require('readline').createInterface({
        input: require('fs').createReadStream('./pdfs/expertrank.txt')
      });
      
      lineReader.on('line', function (line) {
          jsonobj = JSON.parse(line)
          myarr[idx] = new Array(0, jsonobj["name"], jsonobj["features"])
          expertarr[idx] = new Array (idx, jsonobj["name"], jsonobj["features"])
          console.log (myarr[idx][1])
          idx++
      });    
}
// Listen for async message from renderer process
ipcMain.on('async', (event, arg) => {  
    // Print 1
    console.log("message : "+ arg + ": " + retstr);
    if (arg == "updatepic")
    {
        event.sender.send("async-reply", retstr);
    }   
    if (arg != "refresh")
    {
    }
    if (arg.split(",")[0] == "anno")
    {
        buttonval = arg.split(",")[3];
        //document.getElementById ("rationale").style.display="block";
        //document.getElementById ("bettworse").style.display="none";
        top = mainWindow
                let win = new BrowserWindow({ modal: true, parent: top, width: 800, height: 600})
                win.on('closed', () => {
                  win = null
                })
                // Or load a local HTML file
                win.loadURL(`file://${__dirname}/example.html`);
                console.log ("return string: " + retstr)
                if (buttonval == "a")
                win.webContents.executeJavaScript("setpic('"+arg.split(",")[1]+ "')");
                else
                win.webContents.executeJavaScript("setpic('"+arg.split(",")[2]+ "')");
                
                win.openDevTools()
    }
    // Reply on async message from renderer process
    if (arg.split(",")[0] == "refresh")
    {
        if (arg.split(",")[1] != "block")
            update()
        randno = Math.floor(Math.random() * myarr.length)
        console.log ("rand1" + randno)
        randno1 = Math.floor(Math.random() * myarr.length)
        console.log ("rand2" + randno1)
        imga = myarr[randno][1]
        imgb = myarr[randno1][1]
        retstr =  myarr[randno][1] + "," +  myarr[randno1][1] 
        mainWindow.send('async-reply', retstr);
    }

});

function updateImage(event)
{
}

// Listen for sync message from renderer process
ipcMain.on('sync', (event, arg) => {  
    // Print 3
    console.log("sync message " + arg);
    // Send value synchronously back to renderer process
    event.returnValue = 4;
    // Send async message to renderer process
    mainWindow.webContents.send('ping', 5);
});

// Make method externaly visible
exports.pong = arg => {  
    //Print 6
    console.log(arg);
}