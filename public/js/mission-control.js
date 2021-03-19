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

    Livewire.on('loadMap', (data) => {
      if (map == null) {
        map = new MissionMap()
      }
      map.drawRover(data.x, data.y)
      map.drawObstacles(data.obstacles)
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

}