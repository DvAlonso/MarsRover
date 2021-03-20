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

    // On form submit
    $(document).on('submit', '#commands-form', function (event) {
      event.preventDefault()
      let re = new RegExp('^[rRlLfF]*$')
      let value = $('#commands').val()
      if(re.test(value)){
        $('#commands').removeClass('is-invalid')
        let mission = $('#mission_id').val()
        app.sendCommandsToRover(value, mission)
      }
      else{
        $('#commands').addClass('is-invalid')
      }
    })

    Livewire.on('loadMap', (data) => {
      if (map == null) {
        map = new MissionMap()
      }
      map.drawRover(data.x, data.y)
      map.drawObstacles(data.obstacles)
    })

    Livewire.on('loadFinishedMap', (data) => {
      if (map == null) {
        map = new MissionMap()
      }
      map.drawObstacles(data.obstacles)
      map.drawOutput(data.output)
      map.drawStartingPoint(data.starting_x, data.starting_y)
      map.drawRover(data.x, data.y)
      map.zoom()
    })

  },

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