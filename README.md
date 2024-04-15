# Aristotle
An ADRL CLI to debate efficiently

## Commands

### Premise

To add a premise, run the following command;

```shell
vendor/bin/aristotle premise unique_identifer
vendor/bin/aristotle premise unique_identifer "Optional Label"
```

### Conclusion

To add a conclusion, run the following command;

```shell
vendor/bin/aristotle conclusion unique_identifer
vendor/bin/aristotle conclusion unique_identifer "Optional Label"
```

### Valid

To mark a conclusion as valid, run the following command;

```shell
vendor/bin/aristotle valid unique_identifer
vendor/bin/aristotle valid unique_identifer "Optional Label"
```

### inValid

To mark a conclusion as invalid, run the following command;

```shell
vendor/bin/aristotle invalid unique_identifer
vendor/bin/aristotle invalid unique_identifer "Optional Label"
```

### False

To mark a premise as false, run the following command;

```shell
vendor/bin/aristotle false unique_identifer
vendor/bin/aristotle false unique_identifer "Optional Label"
```

### True

To mark a premise as true, run the following command;

```shell
vendor/bin/aristotle true unique_identifer
vendor/bin/aristotle true unique_identifer "Optional Label"
```
