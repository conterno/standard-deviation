<?php 

use Exception;

/*
* Calculates standard deviations.
*/
class StandardDeviationService {
    
    protected $mean               = null;
    protected $min_sample_size    = 3;
    protected $standard_deviation = null;
    protected $values             = [];
    protected $variance           = null;
    
    public function __construct(array $values = null) {
        if (! is_null($values)) {
            $this->setValues($values);
        }
    }
    
    public function setValues(array $values) {
        
        if (count($values) < $this->min_sample_size) {
            throw new exception('Minimum sample size not met.');
        }
        
        $this->values = $values;
        $this->checkValuesAreNumeric();
        $this->calculateStandardDeviation();
    }
    
    public function deviation($values) {
        if (is_null($this->standard_deviation) || empty($this->values)) {
            throw new exception('Deviation cannot be calculated. There are no values set to calculate standard deviation.');
        }
        
        $values = is_array($values) ? $values : [$values];
        $this->checkValuesAreNumeric($values);
        
        $deviations = [];
        foreach ($values as $value) {
            $deviations[$value] = number_format($this->calculateIndividualDeviation($value), 2);
        }

        return count($deviations) > 1 ? $deviations : reset($deviations);
    }
    
    public function getStandardDeviation() {
        return $this->standard_deviation;
    }
    
    public function getMean() {
        return $this->mean;
    }
    
    protected function calculateStandardDeviation() {
        $this->calculateMean();
        $this->calculateVariance();
        $this->standard_deviation = sqrt($this->variance);
    }
    
    protected function checkValuesAreNumeric(array $values = null) {
        $values = $values ?? $this->values;
        
        if (! array_filter($values, 'is_int')) {
            throw new exception('Invalid type, all values must be of type integer or array.');
        }
    }
    
    protected function calculateIndividualDeviation(int $value) {
        return number_format(($value - $this->mean) / $this->standard_deviation, 2);
    }
    
    protected function calculateVariance() {   
        $this->variance = null;
            
        foreach ($this->values as $value) {
            $this->variance += pow(abs($this->mean - $value), 2);
        }
        
        $this->variance /= count($this->values);
    }
    
    protected function calculateMean() {
        $this->mean = array_sum($this->values) / count($this->values);
    }
}
