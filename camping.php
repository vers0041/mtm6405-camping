<?php
// 3.1 
// starting session (always put at top)
session_start();

/**********************************************
 * STARTER CODE
 **********************************************/

/**
 * clearSession
 * This function will clear the session.
 */
function clearSession()
{
  session_unset();
  header("Location: " . $_SERVER['PHP_SELF']);
}

/**
 * Invokes the clearSession() function.
 * This should be used if your session becomes wonky
 */
if (isset($_GET['clear'])) {
  clearSession();
}

/**
 * getResponse
 * Gets the response history array from the session and converts to a string
 * 
 * This function should be used to get the full response array as a string
 * 
 * @return string
 */
function getResponse()
{
  return implode('<br><br>', $_SESSION['camping']['response']);
}

/**
 * updateResponse
 * Adds a new response to the response array found in session
 * Returns the full response array as a string
 * 
 * This function should be used each time an action returns a response
 * 
 * @param [string] $response
 * @return string
 */
function updateResponse($response)
{
  if (!isset($_SESSION['camping'])) {
    createGameData();
  }

  array_push($_SESSION['camping']['response'], $response);

  return getResponse();
}

/**
 * help
 * Returns a formatted string of game instructions
 * 
 * @return string
 */
function help()
{
  return 'Welcome to Camping, the text based camping game. Use the following commands to play the game: <span class="red">fire</span>, <span class="red">wood</span>, <span class="red">tent</span>, <span class="red">roast</span>, <span class="red">rest</span>. To restart the game use the <span class="red">restart</span> command For these instruction again use the <span class="red">help</span> command';
}

/**********************************************
 * YOUR CODE BELOW
 **********************************************/

 // 3.2
 // Create a game array in session
 // set = [] to create an array
 // associate array to use keys as variables instead of numbers
 function createGameData () {
  $_SESSION['camping'] = [
    'response' => [],
    'marshmallows' => 3,
    'wood' => 0, 
    'tent' => false,
    'fire' => false
  ];

  // isset to confirm if a variable or key of an array has been set 
  // check to see if camping 
  return isset($_SESSION['camping']);
 }


/**
 * tent
 * This function will set tent to true
 * to access tent we call $_SESSION
 * ['camping']: access array ['tent']: access property
 */
function tent () {
  $_SESSION['camping']['tent']= true;

  return "The tent has been pitched.";
}
// now tent has been set to true

/**
 * wood
 * Function will increase the amount of wood by 1 if the fire is not true
 */
function wood () {
  if ($_SESSION['camping']['fire'] === false) {
    $_SESSION['camping']['wood']++;

    return "A piece of wood was found.";
  }

  return "The fire must be stopped.";
}


/**
 * fire
 * function to start and stop the fire
 * will set status of fire to false if fire is true
 * will set fire to true if fire is false and wood is < 0 bc need wood to start fire + wood will be decreased by 1
 */
function fire () {
  // check to see if fire is true
  if ($_SESSION['camping']['fire'] === true) {
    // if true need to set fire to false
    $_SESSION['camping']['fire'] = false;

    return "The fire has been stopped."; 

    // check to see if wood is > 0 
    // if set fire to true & decrease wood by one
  } elseif ($_SESSION['camping']['wood'] > 0) {
    $_SESSION['camping']['fire'] = true;
    $_SESSION['camping']['wood']--;

    return "The fire has been started.";
  } else {

    return "There is no more wood";
  }
}

/**
 * roast
 * Will roast mashmallow if fire is true 
 * & marshmallow will decrease by 1
 */ 
function roast () {
  // check if fire is true
  if ($_SESSION['camping']['fire'] === true) {
    // if it is true decrease mashmallow by 1
    if ($_SESSION['camping']['marshmallows'] > 0) {
    // must decrease marshmallow by 1
    $_SESSION['camping']['marshmallows']--;
    return "One marshmallow has been roasted.";

    } else {
      return "There are no more marshmallows.";
    }
  } else {
    return "The fire must be going.";
  }
}

/**
 * rest
 * Will go to sleep if fire is false and tent is true
 */
function rest () {
  // check if fire is false
  if ($_SESSION['camping']['fire'] === false) {
    //check if tent is true
    if ($_SESSION['camping']['tent'] === true) {

    return "Good Night!";

    //this else is connected to tent 
  } else {
    return "The tent must be pitched.";
  }

  // this else is connected to fire
  } else {
    return "The fire must be stopped";
  }
}


 // ### 5
 /**
 * Check for a post command
 *  Check if the function exists for the command provided
 *    Using update response and variable function to execute command
 *    and return the response
 *  Else return a "not valid command" response    
 */
 if (isset($_POST['command'])) {
  if (function_exists($_POST['command'])) {
    updateResponse($_POST['command']());
  } else {
    updateResponse("{$_POST['command']} is not a valid command");
  }
}