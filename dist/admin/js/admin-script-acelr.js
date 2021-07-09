/* eslint-disable camelcase */

/**
 * WordPress dependencies
 */
const {
  __
} = wp.i18n;
const {
  BaseControl,
  Button,
  ExternalLink,
  PanelBody,
  PanelRow,
  Placeholder,
  Spinner,
  ToggleControl
} = wp.components;
const {
  render,
  Component,
  Fragment
} = wp.element;

class App extends Component {
  constructor() {
    super(...arguments);
    this.changeOptions = this.changeOptions.bind(this);
    this.state = {
      isAPILoaded: false,
      isAPISaving: false,
      codeinwp_analytics_status: false,
      codeinwp_analytics_key: ''
    };
  }

  componentDidMount() {
    wp.api.loadPromise.then(() => {
      this.settings = new wp.api.models.Settings();

      if (false === this.state.isAPILoaded) {
        this.settings.fetch().then(response => {
          this.setState({
            codeinwp_analytics_status: Boolean(response.codeinwp_analytics_status),
            codeinwp_analytics_key: response.codeinwp_analytics_key,
            isAPILoaded: true
          });
        });
      }
    });
  }

  changeOptions(option, value) {
    this.setState({
      isAPISaving: true
    });
    const model = new wp.api.models.Settings({
      // eslint-disable-next-line camelcase
      [option]: value
    });
    model.save().then(response => {
      this.setState({
        [option]: response[option],
        isAPISaving: false
      });
    });
  }

  render() {
    if (!this.state.isAPILoaded) {
      return React.createElement(Placeholder, null, React.createElement(Spinner, null));
    }

    return React.createElement(Fragment, null, React.createElement("div", {
      className: "c-header--admin-header"
    }, React.createElement("div", {
      className: "c-header__container"
    }, React.createElement("h1", {
      className: "c-header__heading"
    }, __('Email List on Register Settings')))), React.createElement("div", {
      className: "codeinwp-main"
    }, React.createElement(PanelBody, {
      title: __('Sendinblue Settings')
    }, React.createElement(PanelRow, null, React.createElement(BaseControl, {
      label: __('Sendinblue API Key'),
      help: 'Add your Sendinblue API key',
      id: "codeinwp-options-google-analytics-api",
      className: "c-form__input--text-admin"
    }, React.createElement("input", {
      type: "text",
      id: "codeinwp-options-google-analytics-api",
      value: this.state.codeinwp_analytics_key,
      placeholder: __('Google Analytics API Key'),
      disabled: this.state.isAPISaving,
      onChange: e => this.setState({
        codeinwp_analytics_key: e.target.value
      })
    }), React.createElement("div", {
      className: "codeinwp-text-field-button-group"
    }, React.createElement(Button, {
      isPrimary: true,
      isLarge: true,
      disabled: this.state.isAPISaving,
      onClick: () => this.changeOptions('codeinwp_analytics_key', this.state.codeinwp_analytics_key)
    }, __('Save')), React.createElement(ExternalLink, {
      href: "#"
    }, __('Get API Key'))))), React.createElement(PanelRow, null, React.createElement(ToggleControl, {
      label: __('Track Admin Users?'),
      help: 'Would you like to track views of logged-in admin accounts?.',
      checked: this.state.codeinwp_analytics_status,
      onChange: () => this.changeOptions('codeinwp_analytics_status', !this.state.codeinwp_analytics_status)
    }))), React.createElement(PanelBody, null, React.createElement("div", {
      className: "codeinwp-info"
    }, React.createElement("h2", null, __('Got a question for us?')), React.createElement("p", null, __('We would love to help you out if you need any help.')), React.createElement("div", {
      className: "codeinwp-info-button-group"
    }, React.createElement(Button, {
      isDefault: true,
      isLarge: true,
      target: "_blank",
      href: "#"
    }, __('Ask a question')), React.createElement(Button, {
      isDefault: true,
      isLarge: true,
      target: "_blank",
      href: "#"
    }, __('Leave a review')))))));
  }

}

render(React.createElement(App, null), document.getElementById('codeinwp-awesome-plugin'));