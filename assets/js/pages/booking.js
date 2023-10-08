/* ----------------------------------------------------------------------------
 * Easy!Appointments - Online Appointment Scheduler
 *
 * @package     EasyAppointments
 * @author      A.Tselegidis <alextselegidis@gmail.com>
 * @copyright   Copyright (c) Alex Tselegidis
 * @license     https://opensource.org/licenses/GPL-3.0 - GPLv3
 * @link        https://easyappointments.org
 * @since       v1.5.0
 * ---------------------------------------------------------------------------- */

/**
 * Booking page.
 *
 * This module implements the functionality of the booking page
 *
 * Old Name: FrontendBook
 */
App.Pages.Booking = (function () {
    const $cookieNoticeLink = $('.cc-link');
    const $selectDate = $('#select-date');
    const $selectServiceTile = $('input[type=radio][name=select-service-tile]');
    const $selectProviderTile = $('input[type=radio][name=select-provider-tile]');
    const $selectService = $('#select-service');
    const $selectProvider = $('#select-provider');
    const $selectTimezone = $('#select-timezone');
    const $firstName = $('#first-name');
    const $lastName = $('#last-name');
    const $email = $('#email');
    const $phoneNumber = $('#phone-number');
    const $address = $('#address');
    const $city = $('#city');
    const $zipCode = $('#zip-code');
    const $notes = $('#notes');
    const $captchaTitle = $('.captcha-title');
    const $availableHours = $('#available-hours');
    const $bookAppointmentSubmit = $('#book-appointment-submit');
    const $deletePersonalInformation = $('#delete-personal-information');
    const $interval = $('select[name=interval]');
    const tippy = window.tippy;
    const moment = window.moment;

    /**
     * Determines the functionality of the page.
     *
     * @type {Boolean}
     */
    let manageMode = vars('manage_mode') || false;

    /**
     * Initialize the module.
     */
    function initialize() {
        if (Boolean(Number(vars('display_cookie_notice')))) {
            try {
                cookieconsent.initialise({
                    palette: {
                        popup: {
                            background: '#ffffffbd',
                            text: '#666666'
                        },
                        button: {
                            background: '#000000',
                            text: '#ffffff'
                        }
                    },
                    content: {
                        message: lang('website_using_cookies_to_ensure_best_experience'),
                        dismiss: 'OK'
                    }
                });

                $cookieNoticeLink.replaceWith(
                    $('<a/>', {
                        'data-toggle': 'modal',
                        'data-target': '#cookie-notice-modal',
                        'href': '#',
                        'class': 'cc-link',
                        'text': $cookieNoticeLink.text()
                    })
                );
            } catch (error) {}
        }

        manageMode = vars('manage_mode');

        // Initialize page's components (tooltips, date pickers etc).
        tippy('[data-tippy-content]');

        App.Utils.UI.initializeDatepicker($selectDate, {
            inline: true,
            minDate: moment().subtract(1, 'day').set({hours: 23, minutes: 59, seconds: 59}).toDate(),
            maxDate: moment().add(vars('future_booking_limit'), 'days').toDate(),
            onChange: (selectedDates) => {
                App.Http.Booking.getAvailableHours(moment(selectedDates[0]).format('YYYY-MM-DD'));
                updateConfirmFrame();
            },

            onMonthChange: (selectedDates, dateStr, instance) => {
                setTimeout(() => {
                    const displayedMonthMoment = moment(
                        instance.currentYearElement.value +
                            '-' +
                            (Number(instance.monthsDropdownContainer.value) + 1) +
                            '-01',
                        'YYYY-M-DD'
                    );

                    App.Http.Booking.getUnavailableDates(
                        $selectProvider.val(),
                        $selectService.val(),
                        displayedMonthMoment.format('YYYY-MM-DD')
                    );
                }, 500);
            },

            onYearChange: (selectedDates, dateStr, instance) => {
                setTimeout(() => {
                    const displayedMonthMoment = moment(
                        instance.currentYearElement.value +
                            '-' +
                            (Number(instance.monthsDropdownContainer.value) + 1) +
                            '-01'
                    );

                    App.Http.Booking.getUnavailableDates(
                        $selectProvider.val(),
                        $selectService.val(),
                        displayedMonthMoment.format('YYYY-MM-DD')
                    );
                }, 500);
            }
        });

        $selectDate[0]._flatpickr.setDate(new Date());

        const browserTimezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
        const isTimezoneSupported = $selectTimezone.find(`option[value="${browserTimezone}"]`).length > 0;
        $selectTimezone.val(isTimezoneSupported ? browserTimezone : 'Africa/Lagos');

        // Bind the event handlers (might not be necessary every time we use this class).
        addEventListeners();

        optimizeContactInfoDisplay();

        // If the manage mode is true, the appointment data should be loaded by default.
        if (manageMode) {
            applyAppointmentData(vars('appointment_data'), vars('provider_data'), vars('customer_data'));
            $('#wizard-frame-1')
                .css({
                    'visibility': 'visible',
                    'display': 'none'
                })
                .fadeIn();
        } else {
            // Check if a specific service was selected (via URL parameter).
            const selectedServiceId = App.Utils.Url.queryParam('service');

            if (selectedServiceId && $selectService.find('option[value="' + selectedServiceId + '"]').length > 0) {
                $selectService.val(selectedServiceId);
            }

            $selectService.trigger('change'); // Load the available hours.

            // Check if a specific provider was selected.
            const selectedProviderId = App.Utils.Url.queryParam('provider');

            if (selectedProviderId && $selectProvider.find('option[value="' + selectedProviderId + '"]').length === 0) {
                // Select a service of this provider in order to make the provider available in the select box.
                for (const index in vars('available_providers')) {
                    const provider = vars('available_providers')[index];

                    if (provider.id === selectedProviderId && provider.services.length > 0) {
                        $selectService.val(provider.services[0]).trigger('change');
                    }
                }
            }

            if (selectedProviderId && $selectProvider.find('option[value="' + selectedProviderId + '"]').length > 0) {
                $selectProvider.val(selectedProviderId).trigger('change');
            }

            if (
                (selectedServiceId && selectedProviderId) ||
                (vars('available_services').length === 1 && vars('available_providers').length === 1)
            ) {
                $('.active-step').removeClass('active-step');
                $('#step-2').addClass('active-step');
                $('#wizard-frame-1').hide();
                $('#wizard-frame-2').fadeIn();

                $selectService.closest('.wizard-frame').find('.button-next').trigger('click');

                $(document).find('.book-step:first').hide();

                $(document).find('.button-back:first').css('visibility', 'hidden');

                $(document)
                    .find('.book-step:not(:first)')
                    .each((index, bookStepEl) =>
                        $(bookStepEl)
                            .find('strong')
                            .text(index + 1)
                    );
            } else {
                $('#wizard-frame-1')
                    .css({
                        'visibility': 'visible',
                        'display': 'none'
                    })
                    .fadeIn();
            }

            prefillFromQueryParam('#first-name', 'first_name');
            prefillFromQueryParam('#last-name', 'last_name');
            prefillFromQueryParam('#email', 'email');
            prefillFromQueryParam('#phone-number', 'phone');
            prefillFromQueryParam('#address', 'address');
            prefillFromQueryParam('#city', 'city');
            prefillFromQueryParam('#zip-code', 'zip');
        }
    }

    function prefillFromQueryParam(field, param) {
        const $target = $(field);

        if (!$target.length) {
            return;
        }

        $target.val(App.Utils.Url.queryParam(param));
    }

    /**
     * Remove empty columns and center elements if needed.
     */
    function optimizeContactInfoDisplay() {
        // If a column has only one control shown then move the control to the other column.

        const $firstCol = $('#wizard-frame-3 .field-col:first');
        const $firstColControls = $firstCol.find('.form-control');
        const $secondCol = $('#wizard-frame-3 .field-col:last');
        const $secondColControls = $secondCol.find('.form-control');

        if ($firstColControls.length === 1 && $secondColControls.length > 1) {
            $firstColControls.each((index, controlEl) => {
                $(controlEl).parent().insertBefore($secondColControls.first().parent());
            });
        }

        if ($secondColControls.length === 1 && $firstColControls.length > 1) {
            $secondColControls.each((index, controlEl) => {
                $(controlEl).parent().insertAfter($firstColControls.last().parent());
            });
        }

        // Hide columns that do not have any controls displayed.

        const $fieldCols = $(document).find('#wizard-frame-3 .field-col');

        $fieldCols.each((index, fieldColEl) => {
            const $fieldCol = $(fieldColEl);

            if (!$fieldCol.find('.form-control').length) {
                $fieldCol.hide();
            }
        });
    }

    /**
     * Add the page event listeners.
     */
    function addEventListeners() {
        /**
         * Event: Timezone "Changed"
         */
        $selectTimezone.on('change', () => {
            const date = $selectDate[0]._flatpickr.selectedDates[0];

            if (!date) {
                return;
            }

            App.Http.Booking.getAvailableHours(moment(date).format('YYYY-MM-DD'));

            updateConfirmFrame();
        });
        /**
         * Event: Selected Provider Tile "Changed"
         *
         * When the user clicks on a provider tile radio intut, its available services should
         * become visible.
         */
        $selectProviderTile.on('click', (event) => {
            const $target = $(event.target);
            const providerId = $target.val();
            $selectProvider.val(providerId).trigger('change');
            $('#provider-list').fadeOut(() => {
                $('#service-list')
                    .css({
                        'visibility': 'visible',
                        'display': 'none'
                    })
                    .fadeIn();
            });
        });

        /**
         * Event: Selected Provider "Changed"
         *
         * Whenever the provider changes the available appointment date - time periods must be updated.
         */
        $selectProvider.on('change', (event) => {
            const $target = $(event.target);
            // filter list of service by available provider services
            const filtered = vars('available_providers').filter(
                (provider) => Number(provider.id) === Number($target.val())
            );
            if (filtered.length > 0) {
                const provider = filtered[0];
                var selectedServiceID = Number($selectService.val());
                var hasSelected = false;

                $selectServiceTile.each(function () {
                    var $service = $(this);
                    var serviceID = Number($service.attr('value'));
                    var $parentLabel = $service.parent('label');
                    // Check if current div's value is in filter array
                    if (provider.services.indexOf(serviceID) > -1) {
                        $parentLabel.show();
                        if (selectedServiceID == serviceID) {
                            hasSelected = true;
                        }
                    } else {
                        $parentLabel.hide();
                    }
                });
                // if (!hasSelected) {
                $selectService.val('').trigger('change');
                // }
            }
            App.Http.Booking.getUnavailableDates(
                $target.val(),
                $selectService.val(),
                moment($selectDate[0]._flatpickr.selectedDates[0]).format('YYYY-MM-DD')
            );
            updateConfirmFrame();
        });

        /**
         * Event: Selected Service "Changed"
         *
         * When the user clicks on a service, its available providers should
         * become visible.
         */
        $selectService.on('change', (event) => {
            const $target = $(event.target);
            const serviceId = $selectService.val();
            $interval.prop('selectedIndex', 0);
            if (serviceId) {
                $($selectServiceTile)
                    .filter('[value="' + serviceId + '"]')
                    .prop('checked', true);
                // $selectProvider.empty();
                $('.button-next').show();
            } else {
                $($selectServiceTile).prop('checked', false);
                $availableHours.empty();
                $('.button-next').hide();
            }

            vars('available_providers').forEach((provider) => {
                // If the current provider is able to provide the selected service, add him to the list box.
                // const canServeService =
                //     provider.services.filter((providerServiceId) => Number(providerServiceId) === Number(serviceId))
                //         .length > 0;
                // if (canServeService) {
                // $selectProvider.append(new Option(provider.first_name + ' ' + provider.last_name, provider.id));
                // }
            });

            // Add the "Any Provider" entry.
            // if ($selectProvider.find('option').length > 1 && vars('display_any_provider') === '1') {
            //     $selectProvider.prepend(new Option(lang('any_provider'), 'any-provider', true, true));
            // }

            App.Http.Booking.getUnavailableDates(
                $selectProvider.val(),
                $target.val(),
                moment($selectDate[0]._flatpickr.selectedDates[0]).format('YYYY-MM-DD')
            );

            updateConfirmFrame();

            updateServiceDescription(serviceId);
        });
        /**
         * Event: Selected Service Tile "Changed"
         *
         * When the user clicks on a service tile radio intut, its available providers should
         * become visible.
         */
        $selectServiceTile.on('click', (event) => {
            const $target = $(event.target);
            const serviceId = $target.val();
            $selectService.val(serviceId).trigger('change');
        });
        /**
         * Event: Next Step Button "Clicked"
         *
         * This handler is triggered every time the user pressed the "next" button on the book wizard.
         * Some special tasks might be performed, depending on the current wizard step.
         */
        $('.button-next').on('click', (event) => {
            const $target = $(event.currentTarget);

            // If we are on the first step and there is no provider selected do not continue with the next step.
            if ($target.attr('data-step_index') === '1' && !$selectProvider.val()) {
                return;
            }

            // If we are on the 2nd tab then the user should have an appointment hour selected.
            if ($target.attr('data-step_index') === '2') {
                if (!$('.selected-hour').length) {
                    if (!$('#select-hour-prompt').length) {
                        $('<div/>', {
                            'id': 'select-hour-prompt',
                            'class': 'text-danger mb-4',
                            'text': lang('appointment_hour_missing')
                        }).prependTo('#available-hours');
                    }
                    return;
                }
            }

            // If we are on the 3rd tab then we will need to validate the user's input before proceeding to the next
            // step.
            if ($target.attr('data-step_index') === '3') {
                if (!validateCustomerForm()) {
                    return; // Validation failed, do not continue.
                } else {
                    updateConfirmFrame();
                }
            }

            // Display the next step tab (uses jquery animation effect).
            const nextTabIndex = parseInt($target.attr('data-step_index')) + 1;

            $target
                .parents()
                .eq(1)
                .fadeOut(() => {
                    $('.active-step').removeClass('active-step');
                    $('#step-' + nextTabIndex).addClass('active-step');
                    $('#wizard-frame-' + nextTabIndex).fadeIn();
                });
        });

        /**
         * Event: Back Step Button "Clicked"
         *
         * This handler is triggered every time the user pressed the "back" button on the
         * book wizard.
         */
        $('.button-back').on('click', (event) => {
            const prevTabIndex = parseInt($(event.currentTarget).attr('data-step_index')) - 1;

            $(event.currentTarget)
                .parents()
                .eq(1)
                .fadeOut(() => {
                    $('.active-step').removeClass('active-step');
                    $('#step-' + prevTabIndex).addClass('active-step');
                    $('#wizard-frame-' + prevTabIndex).fadeIn();
                });
        });

        /**
         * Event: Interval select "Changed"
         *
         * This handler is triggered every time the user changes the interval select input.
         * The available hours should be updated accordingly.
         */
        $interval.on('change', (event) => {
            const date = $selectDate[0]._flatpickr.selectedDates[0];

            if (!date) {
                return;
            }

            App.Http.Booking.getAvailableHours(moment(date).format('YYYY-MM-DD'));

            updateConfirmFrame();
        });
        /**
         * Event: Back Select Service Button "Clicked"
         *
         * This handler is triggered every time the user pressed the "Choose another service" button on the
         * book wizard.
         */
        $('.button-back-service').on('click', (event) => {
            const currentIndex = parseInt($(event.currentTarget).attr('data-step_index'));

            $('#wizard-frame-' + currentIndex).fadeOut(() => {
                $('.active-step').removeClass('active-step');
                $('#step-' + '1').addClass('active-step');
                $('#wizard-frame-' + '1').fadeIn();
            });
        });
        /**
         * Event: Back Select Provider Button "Clicked"
         *
         * This handler is triggered every time the user pressed the "Choose another service" button on the
         * first step of thebook wizard.
         */
        $('.button-back-provider').on('click', (event) => {
            $('#service-list').fadeOut(() => {
                $selectService.val('').trigger('change');
                $selectProvider.val('').trigger('change');
                $selectProviderTile.prop('checked', false);
                $selectServiceTile.prop('checked', false);
                $('#provider-list').fadeIn();
            });
        });
        /**
         * Event: Available Hour "Click"
         *
         * Triggered whenever the user clicks on an available hour for his appointment.
         */
        $availableHours.on('click', '.available-hour', (event) => {
            $availableHours.find('.selected-hour').removeClass('selected-hour');
            $(event.target).addClass('selected-hour');
            updateConfirmFrame();
        });

        if (manageMode) {
            /**
             * Event: Cancel Appointment Button "Click"
             *
             * When the user clicks the "Cancel" button this form is going to be submitted. We need
             * the user to confirm this action because once the appointment is cancelled, it will be
             * deleted from the database.
             *
             * @param {jQuery.Event} event
             */
            $('#cancel-appointment').on('click', () => {
                const $cancelAppointmentForm = $('#cancel-appointment-form');

                let $cancellationReason;

                const buttons = [
                    {
                        text: lang('close'),
                        click: (event, messageModal) => {
                            messageModal.dispose();
                        }
                    },
                    {
                        text: lang('confirm'),
                        click: () => {
                            if ($cancellationReason.val() === '') {
                                $cancellationReason.css('border', '2px solid #DC3545');
                                return;
                            }
                            $cancelAppointmentForm.find('#hidden-cancellation-reason').val($cancellationReason.val());
                            $cancelAppointmentForm.submit();
                        }
                    }
                ];

                App.Utils.Message.show(
                    lang('cancel_appointment_title'),
                    lang('write_appointment_removal_reason'),
                    buttons
                );

                $cancellationReason = $('<textarea/>', {
                    'class': 'form-control',
                    'id': 'cancellation-reason',
                    'rows': '3',
                    'css': {
                        'width': '100%'
                    }
                }).appendTo('#message-modal .modal-body');

                return false;
            });

            $deletePersonalInformation.on('click', () => {
                const buttons = [
                    {
                        text: lang('cancel'),
                        click: (event, messageModal) => {
                            messageModal.dispose();
                        }
                    },
                    {
                        text: lang('delete'),
                        click: () => {
                            App.Http.Booking.deletePersonalInformation(vars('customer_token'));
                        }
                    }
                ];

                App.Utils.Message.show(
                    lang('delete_personal_information'),
                    lang('delete_personal_information_prompt'),
                    buttons
                );
            });
        }

        /**
         * Event: Book Appointment Form "Submit"
         *
         * Before the form is submitted to the server we need to make sure that in the meantime the selected appointment
         * date/time wasn't reserved by another customer or event.
         *
         * @param {jQuery.Event} event
         */
        $bookAppointmentSubmit.on('click', () => {
            const $acceptToTermsAndConditions = $('#accept-to-terms-and-conditions');

            $acceptToTermsAndConditions.removeClass('is-invalid');

            if ($acceptToTermsAndConditions.length && !$acceptToTermsAndConditions.prop('checked')) {
                $acceptToTermsAndConditions.addClass('is-invalid');
                return;
            }

            const $acceptToPrivacyPolicy = $('#accept-to-privacy-policy');

            $acceptToPrivacyPolicy.removeClass('is-invalid');

            if ($acceptToPrivacyPolicy.length && !$acceptToPrivacyPolicy.prop('checked')) {
                $acceptToPrivacyPolicy.addClass('is-invalid');
                return;
            }

            App.Http.Booking.registerAppointment();
        });

        /**
         * Event: Refresh captcha image.
         */
        $captchaTitle.on('click', 'button', () => {
            $('.captcha-image').attr('src', App.Utils.Url.siteUrl('captcha?' + Date.now()));
        });

        $selectDate.on('mousedown', '.ui-datepicker-calendar td', () => {
            setTimeout(() => {
                App.Http.Booking.applyPreviousUnavailableDates();
            }, 300);
        });
    }

    /**
     * This function validates the customer's data input. The user cannot continue without passing all the validation
     * checks.
     *
     * @return {Boolean} Returns the validation result.
     */
    function validateCustomerForm() {
        $('#wizard-frame-3 .is-invalid').removeClass('is-invalid');
        $('#wizard-frame-3 label.text-danger').removeClass('text-danger');

        // Validate required fields.
        let missingRequiredField = false;

        $('.required').each((index, requiredField) => {
            if (!$(requiredField).val()) {
                $(requiredField).addClass('is-invalid');
                missingRequiredField = true;
            }
        });

        if (missingRequiredField) {
            $('#form-message').text(lang('fields_are_required'));
            return false;
        }

        // Validate email address.
        if ($email.val() && !App.Utils.Validation.email($email.val())) {
            $email.addClass('is-invalid');
            $('#form-message').text(lang('invalid_email'));
            return false;
        }

        // Validate phone number.
        const phoneNumber = $phoneNumber.val();

        if (phoneNumber && !App.Utils.Validation.phone(phoneNumber)) {
            $phoneNumber.addClass('is-invalid');
            $('#form-message').text(lang('invalid_phone'));
            return false;
        }

        return true;
    }

    /**
     * Every time this function is executed, it updates the confirmation page with the latest
     * customer settings and input for the appointment booking.
     */
    function updateConfirmFrame() {
        $(document)
            .find('.display-selected-provider')
            .text($selectProvider.find('option:selected').text())
            .removeClass('invisible');
        $(document)
            .find('.display-selected-service')
            .text($selectService.find('option:selected').text())
            .removeClass('invisible');
        if ($availableHours.find('.selected-hour').text() === '') {
            return;
        }

        // Appointment Details
        let selectedDate = $selectDate[0]._flatpickr.selectedDates[0];

        if (selectedDate !== null) {
            selectedDate = App.Utils.Date.format(selectedDate, vars('date_format'), vars('time_format'));
        }

        const serviceId = $selectService.val();
        let servicePrice = 'FREE';
        let serviceCurrency = '';
        let serviceDescription = '';
        let serviceDuration = '';
        let readableServiceDuration = '';
        vars('available_services').forEach((service) => {
            if (Number(service.id) === Number(serviceId)) {
                const formatter = new Intl.NumberFormat('en-US', {
                    style: 'currency',
                    currency: service.currency || 'NGN',
                    minimumFractionDigits: 0
                });
                // TODO: modiy to work with any duration
                let duration = Number(service.duration);
                let interval = Number(service.duration);
                if (duration == 60) {
                    interval = Number($interval.val());
                }
                if (Number(service.price) > 0) {
                    servicePrice = formatter.format(service.price * (interval / duration));
                }
                serviceDescription = service.description;
                serviceDuration = interval;
                readableServiceDuration = App.Utils.Date.toHumanReadableTime(interval);
                if (service.availabilities_type == 'fixed' && duration == 60) {
                    $(document).find('.duration-selector').removeClass('hidden');
                } else {
                    $(document).find('.duration-selector').addClass('hidden');
                }
                return false; // Break loop
            }
        });

        $(document).find('.display-selected-service-description').html(serviceDescription).removeClass('invisible');

        $(document).find('.display-selected-service-duration').text(readableServiceDuration).removeClass('invisible');

        $(document).find('.display-selected-service-price').text(servicePrice).removeClass('invisible');

        $(document).find('.display-selected-service-tile').removeClass('invisible');

        $('#appointment-details').empty();

        $('<div/>', {
            'html': [
                $('<h4/>', {
                    'text': lang('appointment')
                }),
                $('<p/>', {
                    'html': [
                        $('<span/>', {
                            'text': lang('service')
                        }),
                        $('<span/>', {
                            'text': $selectService.find('option:selected').text()
                        }),
                        $('<span/>', {
                            'text': lang('provider')
                        }),
                        $('<span/>', {
                            'text': $selectProvider.find('option:selected').text()
                        }),
                        $('<span/>', {
                            'text': lang('duration')
                        }),
                        $('<span/>', {
                            'text': serviceDuration
                        }),
                        $('<span/>', {
                            'text': lang('start')
                        }),
                        $('<span/>', {
                            'text': selectedDate + ' ' + $availableHours.find('.selected-hour').text()
                        }),
                        $('<span/>', {
                            'text': lang('timezone') + ': ' + $selectTimezone.find('option:selected').text()
                        }),
                        $('<span/>', {
                            'text': lang('price'),
                            'prop': {
                                'hidden': !servicePrice
                            }
                        }),
                        $('<span/>', {
                            'text': serviceCurrency + ' ' + servicePrice,
                            'prop': {
                                'hidden': !servicePrice
                            }
                        })
                    ]
                })
            ]
        }).appendTo('#appointment-details');

        // Customer Details
        const firstName = App.Utils.String.escapeHtml($firstName.val());
        const lastName = App.Utils.String.escapeHtml($lastName.val());
        const fullName = firstName + ' ' + lastName;
        const phoneNumber = App.Utils.String.escapeHtml($phoneNumber.val());
        const email = App.Utils.String.escapeHtml($email.val());
        const address = App.Utils.String.escapeHtml($address.val());
        const city = App.Utils.String.escapeHtml($city.val());
        const zipCode = App.Utils.String.escapeHtml($zipCode.val());

        $('#customer-details').empty();

        $('<div/>', {
            'html': [
                $('<h4/>)', {
                    'text': lang('customer')
                }),
                $('<p/>', {
                    'html': [
                        fullName
                            ? $('<span/>', {
                                  'text': lang('customer')
                              })
                            : null,
                        fullName
                            ? $('<span/>', {
                                  'text': fullName
                              })
                            : null,
                        phoneNumber
                            ? $('<span/>', {
                                  'text': lang('phone_number')
                              })
                            : null,
                        phoneNumber
                            ? $('<span/>', {
                                  'text': phoneNumber
                              })
                            : null,
                        email
                            ? $('<span/>', {
                                  'text': lang('email')
                              })
                            : null,
                        email
                            ? $('<span/>', {
                                  'text': email
                              })
                            : null,
                        address
                            ? $('<span/>', {
                                  'text': lang('address')
                              })
                            : null,
                        address
                            ? $('<span/>', {
                                  'text': address
                              })
                            : null,
                        city
                            ? $('<span/>', {
                                  'text': lang('city')
                              })
                            : null,
                        city
                            ? $('<span/>', {
                                  'text': city
                              })
                            : null,
                        zipCode
                            ? $('<span/>', {
                                  'text': lang('zip_code')
                              })
                            : null,
                        zipCode
                            ? $('<span/>', {
                                  'text': zipCode
                              })
                            : null
                    ]
                })
            ]
        }).appendTo('#customer-details');

        // Update appointment form data for submission to server when the user confirms the appointment.
        const data = {};

        data.customer = {
            last_name: $lastName.val(),
            first_name: $firstName.val(),
            email: $email.val(),
            phone_number: $phoneNumber.val(),
            address: $address.val(),
            city: $city.val(),
            zip_code: $zipCode.val(),
            timezone: $selectTimezone.val()
        };

        data.appointment = {
            start_datetime:
                moment($selectDate[0]._flatpickr.selectedDates[0]).format('YYYY-MM-DD') +
                ' ' +
                moment($('.selected-hour').data('value'), 'HH:mm').format('HH:mm') +
                ':00',
            end_datetime: calculateEndDatetime(),
            notes: $notes.val(),
            is_unavailability: false,
            id_users_provider: $selectProvider.val(),
            id_services: $selectService.val()
        };
        if (serviceDuration == 60) {
            data.service_duration = Number($interval.val());
        } else {
            data.service_duration = serviceDuration;
        }

        data.manage_mode = Number(manageMode);

        if (manageMode) {
            data.appointment.id = vars('appointment_data').id;
            data.customer.id = vars('customer_data').id;
        }
        $('input[name="post_data"]').val(JSON.stringify(data));
    }

    /**
     * This method calculates the end datetime of the current appointment.
     *
     * End datetime is depending on the service and start datetime fields.
     *
     * @return {String} Returns the end datetime in string format.
     */
    function calculateEndDatetime() {
        // Find selected service duration.
        const serviceId = $selectService.val();

        const service = vars('available_services').find(
            (availableService) => Number(availableService.id) === Number(serviceId)
        );

        // Add the duration to the start datetime.
        const selectedDate = moment($selectDate[0]._flatpickr.selectedDates[0]).format('YYYY-MM-DD');

        const selectedHour = $('.selected-hour').data('value'); // HH:mm

        const startMoment = moment(selectedDate + ' ' + selectedHour);

        let endMoment;

        if (service.duration && startMoment) {
            endMoment = startMoment.clone().add({'minutes': parseInt(service.duration)});
        } else {
            endMoment = moment();
        }

        return endMoment.format('YYYY-MM-DD HH:mm:ss');
    }

    /**
     * This method applies the appointment's data to the wizard so
     * that the user can start making changes on an existing record.
     *
     * @param {Object} appointment Selected appointment's data.
     * @param {Object} provider Selected provider's data.
     * @param {Object} customer Selected customer's data.
     *
     * @return {Boolean} Returns the operation result.
     */
    function applyAppointmentData(appointment, provider, customer) {
        try {
            // Select Service & Provider
            $selectService.val(appointment.id_services).trigger('change');
            $selectProvider.val(appointment.id_users_provider);

            // Set Appointment Date
            const startMoment = moment(appointment.start_datetime);
            $selectDate[0]._flatpickr.setDate(startMoment.toDate());
            App.Http.Booking.getAvailableHours(startMoment.format('YYYY-MM-DD'));

            // Apply Customer's Data
            $lastName.val(customer.last_name);
            $firstName.val(customer.first_name);
            $email.val(customer.email);
            $phoneNumber.val(customer.phone_number);
            $address.val(customer.address);
            $city.val(customer.city);
            $zipCode.val(customer.zip_code);
            if (customer.timezone) {
                $selectTimezone.val(customer.timezone);
            }
            const appointmentNotes = appointment.notes !== null ? appointment.notes : '';
            $notes.val(appointmentNotes);

            updateConfirmFrame();

            return true;
        } catch (exc) {
            return false;
        }
    }

    /**
     * This method updates the HTML content with a brief description of the
     * user selected service (only if available in db). This is useful for the
     * customers upon selecting the correct service.
     *
     * @param {Number} serviceId The selected service record id.
     */
    function updateServiceDescription(serviceId) {
        const $serviceDescription = $('#service-description');

        $serviceDescription.empty();

        const service = vars('available_services').find(
            (availableService) => Number(availableService.id) === Number(serviceId)
        );

        if (!service) {
            return;
        }

        $('<strong/>', {
            'text': App.Utils.String.escapeHtml(service.name)
        }).appendTo($serviceDescription);

        if (service.description) {
            $('<br/>').appendTo($serviceDescription);

            $('<span/>', {
                'html': App.Utils.String.escapeHtml(service.description).replaceAll('\n', '<br/>')
            }).appendTo($serviceDescription);
        }

        if (service.duration || Number(service.price) > 0 || service.location) {
            $('<br/>').appendTo($serviceDescription);
        }

        if (service.duration) {
            $('<span/>', {
                'text': '[' + lang('duration') + ' ' + service.duration + ' ' + lang('minutes') + ']'
            }).appendTo($serviceDescription);
        }

        if (Number(service.price) > 0) {
            $('<span/>', {
                'text': '[' + lang('price') + ' ' + service.price + ' ' + service.currency + ']'
            }).appendTo($serviceDescription);
        }

        if (service.location) {
            $('<span/>', {
                'text': '[' + lang('location') + ' ' + service.location + ']'
            }).appendTo($serviceDescription);
        }
    }

    // TODO: execute this whenever service changes
    function generateIntervalOptions(fullday, halfDay, duration) {
        let intervals = [];

        for (let i = duration; i <= fullday; i += duration) {
            intervals.push(i);

            if (i >= duration && !intervals.includes(duration)) {
                intervals.push(duration);
            }

            if (i >= halfDay && !intervals.includes(halfDay)) {
                intervals.push(halfDay);
            }
        }
        const $select = $('select[name=interval]');
        $select.empty();
        // Loop through intervals
        $.each(intervals, function (i, interval) {
            // Create option
            const $option = $('<option>').val(interval);

            // Set option text
            if (interval === 4) {
                $option.text('Half day');
            } else if (interval === 9) {
                $option.text('Full day');
            } else {
                const dur = interval / 60;
                $option.text(`${dur} Hour(s)`);
            }

            // Append option
            $select.append($option);
        });
        return intervals;
    }

    document.addEventListener('DOMContentLoaded', initialize);

    return {
        manageMode,
        initialize,
        updateConfirmFrame
    };
})();
