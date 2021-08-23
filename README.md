# kaboomjs-space-invanders
Upadated project based on Ania Kubów source, but this one show you messages if you won and allow you to keep playing if you lose

##
- Game is fullscreen mode
- addLevel section allow to add the number of space invaders, in this case 3 rowa with 17 aliens that at the end means 51 (defined on line 20)

### Game behaviours: 
-- Lose option was defined by the timer at line 119
-- Winner option was defined by the aliens died that in this caae must be 51  is defined at line 173 and go into scene continue_playing at line 290

### Scenes 
-- when game is over message is defined at line 243, this should be updated with a delay timer option instead of the keypress event that I added for now
-- Score that the player made in the lose option is defined at line 262
-- continue_playing is common for both scenarios and is defined at line 292, is based on a basic keypress event

### What you can do next?
-- Add new level
-- Update keypress event for a timer lapse option

This project is based in the explanations made in the online course published by Ania Kubów. Please check out her channel for more: https://www.youtube.com/c/AniaKubów
