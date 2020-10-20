<?php 

/**
 * Create an array of participants
 *
 * @param  int $number_of_persons - total number of participants
 * 
 * @return array $result - an array containing member numbers
 */
function create_persons($number_of_persons) {
    $result = array();

    for ($i = 1; $i <= $number_of_persons; $i++) {
        $result[] = $i;
    }

    return $result;
}

/**
 * selects a given number of random numbers to the team
 *
 * @param  array $persons - array of all participants
 * @param  int $count - number of participants in one team
 * 
 * @return array $result - an array of randomly selected members
 */
function select_team($persons, $count) {
    $result = array();
    $keys = array_rand($persons, $count);
    foreach ($keys as $key) {
        $result[] = $persons[$key];
    }

    return $result;
}

/**
 * Checks if the participant numbers belong to the same team
 *
 * @param  array $team - array of team members
 * @param  mixed $members - searched participant numbers
 * 
 * @return boolean $result - TRUE if the participants are in the same team, else FALSE
 */
function is_members_in_team($team, $members) {
    $result = TRUE;

    foreach($members as $member) {
        $result = $result && array_search($member, $team, TRUE);
    }

    return $result;
}

$attempts = 100;
$success = 0;

$number_of_persons = 20;
$number_in_team = 10;
$members = array(19, 20);

for ($i = 1; $i <= $attempts; $i++) {
    $persons = create_persons($number_of_persons);
    $team = select_team($persons, $number_in_team);
    
    if (is_members_in_team($team, $members)) {
        $success++;
    }
}

$probability =  $success / $attempts;


echo "Участники: ";
foreach ($persons as $person) {
    echo ($person . ",");
}
echo "<br>";
echo "<hr>";

echo "Команда № 1: ";
foreach ($team as $member) {
    echo ($member . ",");
}
echo "<br>";
echo "<hr>";

echo "Искомые номера участников в одной команде:";
foreach ($members as $member) {
    echo ($member . ",");
}
echo "<br>";
echo "<hr>";

echo "Результат: ";
echo("Вероятность попадания участников с номерами 19 и 20 равна " . $probability . " (" . $success . " случаев из " . $attempts . " )");
echo "<br>";
echo "<hr>";
