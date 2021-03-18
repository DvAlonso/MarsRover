class MissionMap {

  constructor () {
    this.gridScale = 6
    this.drawGrid()
  }

  /**
   * Draws the coordinates grid within the canvas
   */
  drawGrid () {
    // Get canvas and 2D context
    let mapCanvas = document.getElementById("mission-map")
    let context = mapCanvas.getContext("2d")

    this.mapCanvas = mapCanvas
    this.context = context

    // Draw grid
    for (var x = 0.2; x <= 600.5; x += this.gridScale) {
      context.moveTo(x, 0)
      context.lineTo(x, 600.5)
    }
    for (var y = 0.2; y <= 600.5; y += this.gridScale) {
      context.moveTo(0, y)
      context.lineTo(600.5, y)
    }
    context.strokeStyle = "#c6c6c6"
    context.stroke()
  }

  /**
   * Draws a black dot representing the rover
   * @param int x 
   * @param int y 
   */
  drawRover (x, y) {
    let scaledX = x*(this.gridScale)
    let scaledY = y*(this.gridScale)
    this.context.fillStyle = '#000'
    this.context.fillRect(scaledX,scaledY,5,5);
  }

  /**
   * Draws red dots representing obstacles
   */
  drawObstacle (x,y) {

  }
}

let missionMap = new MissionMap()

function drawRover() {
  let x = document.getElementById('rover-x').value
  let y = document.getElementById('rover-y').value
  missionMap.drawRover(x,y)
}