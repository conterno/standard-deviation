# standard-deviation
A simple class for calculating standard deviations.

### Sample Use
```
$deviation = new StandardDeviation([2,4,5,6,8]);

$deviation->getDeviation(7);
// Returns 1.00

$deviation->getDeviation([4,5,7]);
/*
* Returns [
*   4 => 0.5,
*   5 => 0,
*   7 => 1
* ]
*/
```
