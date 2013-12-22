## Throttling Management

### Disable the Throttling Feature {#disable-the-throttling-feature}

---

Disables the throttling feature.

Can be done on the throttle provider (global) level or on a throttle instance itself.

#### Example

	// Get the Throttle Provider
	$throttleProvider = Sentry::getThrottleProvider();

	// Disable the Throttling Feature
	$throttleProvider->disable();

### Enable the Throttling Feature {#enable-the-throttling-feature}

---

Enables the throttling feature.

Can be done on the throttle provider (global) level or on a throttle instance itself.

#### Example

	// Get the Throttle Provider
	$throttleProvider = Sentry::getThrottleProvider();

	// Enable the Throttling Feature
	$throttleProvider->enable();

### Check the Throttling Feature Status {#check-the-throttling-feature-status}

---

Checks to see if the throttling feature is enabled or disabled.

#### Example

	// Get the Throttle Provider
	$provider = Sentry::getThrottleProvider();

	// Check if the Throttling feature is enabled or disabled
	if($provider->isEnabled())
	{
		// The Throttling Feature is Enabled
	}
	else
	{
		// The Throttling Feature is Disabled
	}
