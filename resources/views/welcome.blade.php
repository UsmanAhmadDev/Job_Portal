{{-- <!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Stripo Plugin Example</title>
    <style>
      html, body {
        min-width: 1200px;
        height: 100%;
      }
      #stripoEditorContainer {
        height: calc(100% - 48px);
      }
      #externalSystemContainer {
        background-color: darkgrey;
        padding: 5px 20px;
        display: flex;
        justify-content: space-between;
      }
      .control-button {
        border-radius: 17px;
        padding: 5px 10px;
        border-color: grey;
        cursor: pointer;
      }
      #exportButton,
      #saveButton {
        background: #b5e8b5;
      }
      .btn-group button {
        padding: 5px 10px;
        cursor: pointer;
        float: left;
      }
      .btn-group button:first-child {
        border-radius: 17px 0 0 17px;
      }
      .btn-group button:not(:last-child) {
        border-right: none;
      }
      .btn-group button:last-child {
        border-radius: 0 17px 17px 0;
      }
      .btn-group button.active {
        background-color: darkgrey;
      }
      .avatar-preview {
        width: 34px;
        height: 34px;
        border-radius: 15px;
        background-size: cover;
        display: inline-block;
        margin-left: 5px;

      }
      /* Notifications styles */
      .notification-zone {
        position: fixed;
        width: 400px;
        z-index: 99999;
        right: 30px;
        bottom: 80px;
      }
      .alert-success {
        color: #046904;
        background: #b5e8b5;
        padding: 5px 10px;
        border: 2px solid #046904;
        border-radius: 15px;
      }
    </style>
  </head>
  <body>

  <!--This is your own external header where you can place plugin buttons -->
  <div id="externalSystemContainer">
    <div style="padding-top: 5px;color: black">
      EXTERNAL HEADER OUTSIDE THE EDITOR
    </div>

    <div class="btn-group">
      <button id="undoButton">Undo</button>
      <button id="versionHistoryButton">History</button>
      <button id="redoButton">Redo</button>
    </div>
    <div>
      <button id="codeEditor" class="control-button">Code editor</button>
    </div>
    <div class="btn-group viewSwitcher">
      <button id="desktopViewButton" class="active">Desktop</button>
      <button id="mobileViewButton">Mobile</button>
    </div>
    <div>
      <button id="saveButton" class="control-button">Save</button>
      <button id="exportButton" class="control-button">Export</button>
    </div>
    <div class="avatars"></div>
  </div>

  <!--This is your own area for notification messages -->
  <div class="notification-zone"></div>

  <!--This is a Stripo plugin container -->
  <div id="stripoEditorContainer"/> <!-- PLACE IN THE CODE WHERE TO PLACE A STRIPO EDITOR -->

  <!--External utility methods to interact with UI and load demo template code -->
  <script>
    function request(method, url, data, callback) {
      var req = new XMLHttpRequest();
      req.onreadystatechange = function () {
        if (req.readyState === 4 && req.status === 200) {
          callback(req.responseText);
        } else if (req.readyState === 4 && req.status !== 200) {
          console.error('Can not complete request. Please check you entered a valid PLUGIN_ID and SECRET_KEY values');
        }
      };
      req.open(method, url, true);
      if (method !== 'GET') {
        req.setRequestHeader('content-type', 'application/json');
      }
      req.send(data);
    }

    function loadDemoTemplate(callback) {
      request('GET', 'https://raw.githubusercontent.com/ardas/stripo-plugin/master/Public-Templates/Basic-Templates/Trigger%20newsletter%20mockup/Trigger%20newsletter%20mockup.html', null, function(html) {
        request('GET', 'https://raw.githubusercontent.com/ardas/stripo-plugin/master/Public-Templates/Basic-Templates/Trigger%20newsletter%20mockup/Trigger%20newsletter%20mockup.css', null, function(css) {
          callback({html: html, css: css});
        });
      });
    }

    document.querySelectorAll('.viewSwitcher button').forEach(function(button) {
      button.addEventListener('click', function(e) {
        document.querySelectorAll('.viewSwitcher button').forEach(function(btn) {
          btn.classList.remove('active');
        });
        e.target.classList.add('active');
      })
    });
  </script>

  <!--External code to show notifications -->
  <script>
    var notifications = {
      autoCloseTimeout: 10000,
      container: document.querySelector('.notification-zone'),
      error: function (text, id, params) {
        this.showNotification(this.getErrorNotification.bind(this), text, id, params);
      },
      warn: function (text, id, params) {
        this.showNotification(this.getWarningNotification.bind(this), text, id, params);
      },
      info: function (text, id, params) {
        this.showNotification(this.getInfoNotification.bind(this), text, id, params);
      },
      success: function (text, id, params) {
        this.showNotification(this.getSuccessNotification.bind(this), text, id, params);
      },
      loader: function (text, id, params) {
        this.showNotification(this.getLoaderNotification.bind(this), text, id, params);
      },
      hide: function (id) {
        var toast = $('#' + id, this.container);
        toast.effect('fade', 600, function () {
          toast.remove()
        })
      },
      showNotification: function (notificationGetter, text, id, params) {
        params = Object.assign({autoClose: true, closeable: true}, params || {});
        if (!id || !document.querySelectorAll('#' + id).length) {
          var toast = notificationGetter(text, id, !params.closeable);
          this.container.appendChild(toast);
          if (params.autoClose) {
            setTimeout(function () {
                toast.remove()
            }, this.autoCloseTimeout);
          }
        }
      },
      getErrorNotification: function (text, id, nonclosable) {
        return this.getNotificationTemplate('alert-danger', text, id, nonclosable);
      },
      getWarningNotification: function (text, id, nonclosable) {
        return this.getNotificationTemplate('alert-warning', text, id, nonclosable);
      },
      getInfoNotification: function (text, id, nonclosable) {
        return this.getNotificationTemplate('alert-info', text, id, nonclosable);
      },
      getSuccessNotification: function (text, id, nonclosable) {
        return this.getNotificationTemplate('alert-success', text, id, nonclosable);
      },
      getLoaderNotification: function (text, id) {
        var notification = this.createDomElement('\
          <div class="alert alert-info" role="alert">\
          <div style="width:auto; margin-right: 15px; float: left !important;">\
              <div style="width:20px;height:20px;border-radius:50%;box-shadow:1px 1px 0px #31708f;\
                animation:cssload-spin 690ms infinite linear"></div>\
            </div>' + text + '\
          </div>');
        id && notification.setAttribute('id', id);
        return notification;
      },
      getNotificationTemplate: function (classes, text, id) {
        var notification = this.createDomElement('\
          <div class="alert alert-dismissible ' + classes + '" role="alert">' + text +
          '</div>');
        id && notification.setAttribute('id', id);
        return notification;
      },
      createDomElement(template) {
        var div = document.createElement('div');
        div.innerHTML = template.trim();
        return div.firstChild;
      }
    };
  </script>

  <!--External code to demonstrate Stripo API calls in action -->
  <script>
    //the getTemplate() function example
    document.querySelector('#saveButton').addEventListener('click', function () {
      window.StripoEditorApi.actionsApi.getTemplate(function (html, css) {
        //your save logic should be here
        console.log('%cThis method returns the HTML and CSS codes with the Plugin internal extra styles and editor markup.', 'background-color: #d8f0d8');
        console.log('The HTML:');
        console.log(html);
        console.log('The CSS:');
        console.log(css);
      });
      notifications.success('The operation is successful. You can find the code in the console of your browser. This is an example of the getTemplate() function in action.');
    });

    //the compileEmail() function example
    document.querySelector('#exportButton').addEventListener('click', function () {
      window.StripoEditorApi.actionsApi.compileEmail(
        {
          callback: function (error, html, ampHtml, ampErrors) {
            //your save logic should be here
            console.log('%cThis method returns compiled and compressed HTML code that is ready to be sent out to clients.', 'background-color: #d8f0d8');
            console.log(html);
          }
        }
      );
      notifications.success('The operation is successful. You can find the code in the console of your browser. This is an example of the compileEmail() function in action.');
    });
  </script>

  <script>
    // Call this function to start plugin.
    // For security reasons it is STRONGLY recommended NOT to store your PLUGIN_ID and SECRET_KEY on client side.
    // Please use backend middleware to authenticate plugin.
    // See documentation: https://plugin.stripo.email/
    function initPlugin(template) {
      const script = document.createElement('script');
      script.id = 'UiEditorScript';
      script.type = 'text/javascript';
      script.src = 'https://plugins.stripo.email/resources/uieditor/latest/UIEditor.js';
      script.onload = function () {
        window.UIEditor.initEditor(
          document.querySelector('#stripoEditorContainer'),
          {
            html: template.html,
            css: template.css,
            metadata: {
              emailId: '123',
              username: 'Plugin Demo User',
              avatarUrl: 'https://plugin.stripocdn.email/content/guids/CABINET_eab4e7d5a4603ac03f4120652a3a5a540f0c79c688514939f095f67433ed4a67/images/photo256.png'
            },
            locale: 'en',
            onTokenRefreshRequest: function (callback) {
              request('POST', 'https://plugins.stripo.email/api/v1/auth',
                JSON.stringify({
                  pluginId: 'YOUR_PLUGIN_ID',
                  secretKey: 'YOUR_SECRET_KEY',
                  userId: '1',
                  role: 'user'
                }),
                function(data) {
                  callback(JSON.parse(data).token);
                }
              );
            },
            onUserListChange: function (usersList) {
              document.querySelector('.avatars').innerHTML = usersList
                .map(u => '<div class="avatar-preview" style="background-image: url(' + u.avatar + ');"></div>')
                .join('');
            },
            codeEditorButtonSelector: '#codeEditor',
            undoButtonSelector: '#undoButton',
            redoButtonSelector: '#redoButton',
            versionHistoryButtonSelector: '#versionHistoryButton',
            mobileViewButtonSelector: '#mobileViewButton',
            desktopViewButtonSelector: '#desktopViewButton',
            notifications: {
              info: notifications.info.bind(notifications),
              error: notifications.error.bind(notifications),
              warn: notifications.warn.bind(notifications),
              loader: notifications.loader.bind(notifications),
              hide: notifications.hide.bind(notifications),
              success: notifications.success.bind(notifications)
            }
          }
        );
      };
      document.body.appendChild(script);
    }

    loadDemoTemplate(initPlugin);
  </script>
  </body>
</html> --}}