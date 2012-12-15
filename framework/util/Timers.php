<?php

namespace framework\util;

/**
 * Created by JetBrains PhpStorm.
 * User: mac
 * Date: 12-8-15
 * Time: 下午8:43
 * To change this template use File | Settings | File Templates.
 */
class Timers {

    /**
     * An array of the arrays that represent
     * the timer information used by Timers::tick
     *
     * @access private
     * @staticvar array
     */
    private static $timers = array();

    /**
     * Tracker of timers
     *
     *
     * @access private
     * @staticvar integer
     */
    private static $numTimers = 0;

    /**
     * An array of the arrays that represent
     * the interval information used by Timers::tick
     *
     * @access private
     * @staticvar array
     */
    private static $intervals = array();

    /**
     * Tracker of intervals
     *
     *
     * @access private
     * @staticvar integer
     */
    private static $numIntervals = 0;

    /**
     * Used for debugging
     *
     *
     * @access private
     * @staticvar integer
     */
    //private static $ticks = 0;

    /**
     * The soonest scheduled time.
     *
     *
     * @access private
     * @staticvar integer
     */
    private static $nextTime = 0;

    /**
     * A utility method called after N number of ticks by the engine
     * that checks each timer and interval to see if the desired
     * number of milliseconds have passed and executes the function
     * when appropriate
     *
     * @static
     * @return void
     */
    public static function tick() {
        //++self::$ticks;

        $time = self::millitime();

        // Quit fast!
        if ($time < self::$nextTime)
            return;
        self::$nextTime = 0;

        foreach (self::$timers as $position => $timer) {
            if ($time >= $timer['time']) {
                call_user_func($timer['function']);
                unset(self::$timers[$position]);
            }
        }

        foreach (self::$intervals as $position => $timer) {
            if ($time >= $timer['time']) {
                call_user_func($timer['function']);
                $nextTime = self::millitime() + self::$intervals[$position]['milliseconds'];
                self::setNextTime($nextTime);
                self::$intervals[$position]['time'] = $nextTime;
            }
        }
    }

    /**
     * A utility method for setting the soonest scheduled time.
     *
     * @static
     * @return float
     */
    private static function setNextTime($nextTime) {
        if (self::$nextTime == 0 || self::$nextTime > $nextTime)
            self::$nextTime = $nextTime;
    }

    /**
     * A utility method for retrieving the most accurate time available
     *
     * @static
     * @return float
     */
    public static function millitime() {
        return microtime(true) * 1000; // this is faster and precise enough
    }

    /**
     * A utility method that ensures that all the timeouts have been called
     * and that calls all the intervals one more time
     *
     *
     * @static
     * @return void
     */
    public static function shutdown() {
        foreach (self::$timers as $position => $timer) {
            call_user_func($timer['function']);
            unset(self::$timers[$position]);
        }

        foreach (self::$intervals as $position => $interval) {
            call_user_func($interval['function']);
            unset(self::$intervals[$position]);
        }

        //print "\nticks: " . self::$ticks;
    }

    /**
     * Add a function to the be executed after ($milliseconds) millisecond
     *
     * @static
     *
     * @param callable | string $func
     * @param float $milliseconds
     *
     * @return integer
     */
    public static function setTimeout($func, $milliseconds) {
        if (!\is_callable($func)) {
            if (\is_string($func)) {
                $func = \create_function('', $func);
            } else {
                throw new \Exception('no function');
            }
        }

        $nextTime = self::millitime() + $milliseconds;
        self::setNextTime($nextTime);
        self::$timers[++self::$numTimers] = array(
            'time' => $nextTime,
            'function' => $func,
        );

        return self::$numTimers;
    }

    /**
     * Add a function to the be executed every ($milliseconds) millisecond
     *
     * @static
     *
     * @param callable | string $func
     * @param float $milliseconds
     *
     * @return integer
     */
    public static function setInterval($func, $milliseconds) {
        if (!is_callable($func)) {
            if (is_string($func)) {
                $func = create_function('', $func);
            } else {
                throw new \Exception('no function');
            }
        }

        $nextTime = self::millitime() + $milliseconds;
        self::setNextTime($nextTime);
        self::$intervals[++self::$numIntervals] = array(
            'time' => $nextTime,
            'function' => $func,
            'milliseconds' => $milliseconds,
        );

        return self::$numIntervals;
    }

    /**
     * Remove a timeout function from the stack
     *
     * @static
     *
     * @param integer $timer
     *
     * @return boolean
     */
    public static function clearTimeout($timer) {
        if (isset(self::$timers[$timer])) {
            unset(self::$timers[$timer]);
            return true;
        }

        return false;
    }

    /**
     * Remove an interval function from the stack
     *
     * @static
     *
     * @param integer $interval
     *
     * @return boolean
     */
    public static function clearInterval($interval) {
        if (isset(self::$intervals[$interval])) {
            unset(self::$intervals[$interval]);
            return true;
        }

        return false;
    }

}

/**
 * Register these methods in order to perform polling a specific intervals
 * that are set by the user
 */
register_tick_function(array('\\framework\\util\\Timers', 'tick'));
//register_shutdown_function(array('\\framework\\util\\Timers','shutdown'));
