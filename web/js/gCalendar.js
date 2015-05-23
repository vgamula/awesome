
app.gCalendarExport = function(gKey, eventObj, callback) {

    var CLIENT_ID = gKey;
    var SCOPES = ['https://www.googleapis.com/auth/calendar'];

    /**
     * Check if current user has authorized this application.
     */
    function checkAuth() {
      gapi.auth.authorize(
        {
          'client_id': CLIENT_ID,
          'scope': SCOPES,
          'immediate': true
        }, handleAuthResult);
    }

    /**
     * Enter point
     *
     */
    function tryExport() {
      gapi.auth.authorize(
        {client_id: CLIENT_ID, scope: SCOPES, immediate: false},
        handleAuthResult);
      return false;
    }

    /**
     * Handle response from authorization server.
     *
     */
    function handleAuthResult(authResult) {
      if (authResult && !authResult.error) {
        loadCalendarApi();
      }
    }

    /**
     * Load Google Calendar client library. List upcoming events
     * once client library is loaded.
     */
    function loadCalendarApi() {
      gapi.client.load('calendar', 'v3', exportEvents);
    }

    /*
    * Google API request call
    */
    function exportEvents() {


        // setup event details
        var resource = {
          "summary": eventObj.title,
          "start": {
            "dateTime": eventObj.from,
          },
          "end": {
            "dateTime": eventObj.to,
          }
        };

        var request = gapi.client.calendar.events.insert({
          'calendarId':		'primary',	// calendar ID
          "resource":			resource		// pass event details with api call
        });

        // handle the response from our api call
        request.execute(function(resp) {

          if (typeof(callback) === 'function') callback(resp.status=='confirmed'); // true or false
          //console.log(resp);
        });
    }

    tryExport();

};
