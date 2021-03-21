$(function () {
  app.init()
});

var map = null

const app = {
  init: function () {
    this.events()
  },

  events: function () {

    // On form submit
    $(document).on('submit', '#preparation-form', function (event) {
      event.preventDefault()
      let mission = $('#mission_id').val()
      let x = $('#landingX').val()
      let y = $('#landingY').val()
      if ((x >= 0 && x <= 99) && (y >= 0 && y <= 99)) {
        app.launchRover(x, y, mission)
      }
    })

    // Prevent the user from entering non-desired commands
    $(document).on('keydown', '#commands', function(event){
      if(event.keyCode != 70 && event.keyCode != 76 && event.keyCode != 82 && event.keyCode != 8) {
        event.preventDefault()
      }
    })

    // On form submit make sure the value is not empty and matches RFL chars
    $(document).on('submit', '#commands-form', function (event) {
      event.preventDefault()
      let re = new RegExp('^[rRlLfF]*$')
      let value = $('#commands').val()
      if(re.test(value) && value !== ''){
        $('#commands').removeClass('is-invalid')
        let mission = $('#mission_id').val()
        app.sendCommandsToRover(value, mission)
      }
      else{
        $('#commands').addClass('is-invalid')
      }
    })

    /**
     * On load map event (emited by the component being rendered)
     * Draw the map, the rover and the randomly generated obstacles
     */
    Livewire.on('loadMap', (data) => {
      if (map == null) {
        map = new MissionMap()
      }
      map.drawRover(data.x, data.y)
      map.drawObstacles(data.obstacles)
    })

    /**
     * On load finished map event (emited by the component being rendered)
     * Draw the map, with the rover and it's travelled path and obstacles
     * Converts the canvas into an image so we can zoom
     * Inserts the output into the <pre> tag so we can see the rover's output
     */
    Livewire.on('loadFinishedMap', (data) => {
      map = new MissionMap()
      map.drawObstacles(data.obstacles)
      map.drawOutput(data.output)
      map.drawStartingPoint(data.starting_x, data.starting_y)
      map.drawRover(data.x, data.y)

      // Convert the canvas to an image so we can zoom / drag around
      let canvasAsDataUrl = document.getElementById('mission-map').toDataURL()
      $('#mission-map').remove()
      let img = document.createElement('img')
      img.id = 'mission-map'
      img.src = canvasAsDataUrl
      img.style.width = '600px'
      img.style.height = '600px'
      $('#canvas-wrapper').append(img)
      wheelzoom(document.querySelectorAll('#mission-map'));

      $('#output').text(JSON.stringify(data.output, undefined, 2).replace('[', '{').replace(']', '}'))

    })

  },

  /**
   * Launches the rover into the specified position
   * @param int x 
   * @param int y 
   * @param string mission 
   */
  launchRover: function (x, y, mission) {
    Livewire.emit('loading', 'Launching rover into coordinates...')
    axios.post('/api/mission/launch', {
      _token,
      landingX: x,
      landingY: y,
      mission
    })
      .then(function () {
        Livewire.emit('loaded')
      })
  },

  /**
   * Sends the commands to the rover
   * @param string commands 
   * @param string mission 
   */
  sendCommandsToRover: function (commands, mission) {
    Livewire.emit('loading', 'Sending input commands to the rover...')
    axios.post('/api/mission/commands', {
      _token,
      commands,
      mission
    })
      .then(function () {
        Livewire.emit('loaded')
      })
  }

}