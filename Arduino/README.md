# Something I learn about Arduino...

### I2C and time
No time function can be executed on I2C onReceived and onRequest slave function handlers.
Calling **delay** or **millis** inside these callback functions produce no effect (**delay** will not stop the execution, **millis** will not go on with milliseconds counting).


### I2C and slave writing
Slave device can use the **Wire.write** function only inside a **onRequest** callback.
Slave can't write something outside that callback function.
If the slave need to send something to the master it can do that just after a **requestFrom** master calling.

### LCD contrast
Contrast pin (V0)in LCD display with chip HD44780 depends on received voltage and must be regulated by a potentiometer.

### Stepper motor 28BYJ-48
- This kinkd of motor won't working with insufficient voltage. If I need to provide current by battery, that must be completely charged.
- 