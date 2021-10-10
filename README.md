# Space Invanders build with KaboomJS 

 **[kaboom](https://kaboomjs.com/  "kaboom")** is a JavaScript library that is a great option for Gaming plataforms


![Screen](https://github.com/satrianivzla/kaboomjs-space-invanders/blob/main/screen.jpg)

> Updated project based on **[Ania Kubów](https://github.com/kubowania/space-invaders-kaboom.js "Ania Kubów Original Source")** source, but this one show you messages if you won and allow you to keep playing if you lose

## Updates
- Game is fullscreen mode
- addLevel section allow to add the number of space invaders, in this case 3 rowa with 17 aliens that at the end means 51 (defined on line 20)

## Game behaviours: 
- Lose option was defined by the timer at line 119
- Winner option was defined by the aliens died that in this caae must be 51  is defined at line 173 and go into scene continue_playing at line 290

## Scenes 
- when game is over message is defined at line 243, this should be updated with a delay timer option instead of the keypress event that I added for now
- Score that the player made in the lose option is defined at line 262
- continue_playing is common for both scenarios and is defined at line 292, is based on a basic keypress event

## What you can do next?
- Add new level
- Update keypress event for a timer lapse option

## Kudos to Ania Kubów
This project is based in the explanations made in the online course published by [Ania Kubów](https://www.youtube.com/c/AniaKubów "Ania Kubów Youtube"), please check out her youtube channel for more.

## More info about KaboomJS
 **[Ofiicial Website](https://kaboomjs.com/  "kaboom")** | 
 **[Github](https://github.com/replit/kaboom "kaboom")** 

## License
This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details
