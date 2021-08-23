// Basic configuration to get game working in fullscreen mode
kaboom({
  global: true,
  fullscreen: true,
  scale: 1,  
})

loadRoot('https://i.imgur.com/')
loadSprite('space-invader', 'xm4uekq.png')
loadSprite('space-ship', 'yxiLtVW.png')
loadSprite('wall', 'fCKsBPE.png')

scene('game', () => {
  const MOVE_SPEED = 300
  const BULLET_SPEED = 320
  const INVADER_SPEED = 150
  const LEVEL_DOWN = 58
  let CURRENT_SPEED = INVADER_SPEED

  layers(['obj', 'ui'], 'obj')
// Here you defined how many aliens will be in the screen
// Then for now are 3 rows with 17 aliens each one
// and you have 51 aliens ready to die!
  addLevel(
    [
      '!^^^^^^^^^^^^^^^^^   &',
      '!^^^^^^^^^^^^^^^^^   &',
      '!^^^^^^^^^^^^^^^^^   &',
      '!                    &',
      '!                    &',
      '!                    &',
      '!                    &',
      '!                    &',
      '!                    &',
      '!                    &',
    ],
    {
      // TODO: derive grid size from sprite size instead of hardcode
      // grid size
      width: 80,
      height: 58,
      // define each object as a list of components
      '^': [sprite('space-invader'), solid(), scale(0.7), 'space-invader'],
      '!': [sprite('wall'), solid(), 'left-side'],
      '&': [sprite('wall'), solid(), 'right-side'],
    },
    pos(width() / 2, height() / 2),
    origin('center'),
  )
  function lifespan(time) {
    let timer = 0
    return {
      update() {
        timer += dt()
        if (timer >= time) {
          destroy(this)
        }
      },
    }
  }

  function late(t) {
    let timer = 0
    return {
      add() {
        this.hidden = true
      },
      update() {
        timer += dt()
        if (timer >= t) {
          this.hidden = false
        }
      },
    }
  }

  add([
    text('READY', 24),
    pos(width() / 2, height() / 2),
    origin('center'),
    lifespan(1),
    layer('ui'),
  ])

  add([
    text('STEADY', 24),
    pos(width() / 2, height() / 2),
    origin('center'),
    lifespan(2),
    late(1),
    layer('ui'),
  ])

  add([
    text('GO!', 40),
    pos(width() / 2, height() / 2),
    origin('center'),
    lifespan(4),
    late(2),
    layer('ui'),
  ])

  const score = add([
    text('0'),
    pos(50, 500),
    scale(2),
    layer('ui'),
    {
      value: 0,
    },
  ])

  const timer = add([
    text(0),
    pos(50, 530),
    scale(2),
    layer('ui'),
    {
      time: 60,
    },
  ])

  timer.action(() => {
    timer.time -= dt()
    timer.text = timer.time.toFixed(2)
    if (timer.time <= 0) {
      go('game_over', score.value)
    }
  })

  const player = add([
    sprite('space-ship'),
    scale(0.7),
    layer('obj'),
    pos(width() / 2, height() - 58),
    origin('center'),
  ])

  keyDown('left', () => {
    player.move(-MOVE_SPEED, 0)
  })

  keyDown('right', () => {
    player.move(MOVE_SPEED, 0)
  })

  function spawnBullet(p) {
    add([rect(6, 18), pos(p), origin('center'), color(0.5, 0.5, 1), 'bullet'])
  }

  keyPress('space', () => {
    spawnBullet(player.pos.add(0, -25))
  })

  // run this callback every frame for all objects with tag "bullet"
  action('bullet', (b) => {
    b.move(0, -BULLET_SPEED)
    // remove the bullet if it's out of the scene for performance
    if (b.pos.y < 0) {
      destroy(b)
    }
  })

  collides('bullet', 'space-invader', (b, s) => {
    camShake(4)
    destroy(b)
    destroy(s)
    score.value++
    score.text = score.value
	// Check if player has won
	// 51 is the number of aliens defined in
	// the addlevel section in the line 24
		if (score.value == 51) {
	      go('winner', score.value)		
		}	
  })

  action('space-invader', (s) => {
    s.move(CURRENT_SPEED, 0)
  })

  collides('space-invader','right-side', () => {
    CURRENT_SPEED = -INVADER_SPEED
    every('space-invader', (obj) => {
      obj.move(0, LEVEL_DOWN)
    })
  })

  collides('space-invader', 'left-side', () => {
    CURRENT_SPEED = INVADER_SPEED
    every('space-invader', (obj) => {
      obj.move(0, LEVEL_DOWN)
    })
  })

  player.collides('space-invader', () => {
    go('game_over', score.value)
  })
  
  action('space-invader', (s) => {
		if (s.pos.y >= height()) {
			// switch to "death" scene
			go("game_over", score.value);
		}
	})
    // Added button suffort but I haven't added 
	// to the project yet
	function addButton(txt, p, f) {

		const bg = add([
			pos(p),
			rect(60, 30),
			area(),
			origin("center"),
			color(1, 1, 1),
		]);

		add([
			text(txt, 8),
			pos(p),
			origin("center"),
			color(0, 0, 0),
		]);

		bg.action(() => {
			if (bg.isHovered()) {
				bg.color = rgb(0.8, 0.8, 0.8);
				if (mouseIsClicked()) {
					f();
				}
			} else {
				bg.color = rgb(1, 1, 1);
			}
		});

	}
	
})

// Game Over screen message
// should have a delay timer instead
// the keypress event 
scene('game_over', (score) => {

 	add([
    	text('Game Over!', 24),
        origin('center'),      
		pos(width() / 2, height() / 2),
   	])	

	keyPress("space", (score) => {	
	  go('scored', score.value);
	});		
 
 })
 
// Here is the screen where you must show
// How many aliens were killed by the player
// in a complex scenario here must add the
// top 10 players that spend less time to
// finish this basic level for example
scene('scored', (score) => {
 add([
    text("Your Score: " + score, 24),
    origin('center'),
    pos(width() / 2, height() / 2),
  ])

	keyPress("space", () => {	
	  go('continue_playing');
	});	

}) 

// Finished level screen message
// if you added a new level you have 
// to create a scene with a process to 
// to allow to play it
scene('winner', (score) => {
	add([
		text("You have finished this Level", 24),
		origin('center'),
		pos(width() / 2, height() / 2),	
	])	
	keyPress("space", () => {	
	  go('continue_playing');
	});	
}) 

// Here is the message to keep playing must be
// a question based option 
scene('continue_playing', (score) => {
 	add([
		text("Pulse spacebar to play next level", 24),
		origin('center'),
		pos(width() / 2, height()  / 2),	
	])	
 
	keyPress("space", () => {	
	  go('game');
	});	 
 }) 
// Get ready to play!  
start('game')
