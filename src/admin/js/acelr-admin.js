/* eslint-disable camelcase */
/**
 * WordPress dependencies
 */
const { __ } = wp.i18n;

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
        super( ...arguments );

        this.changeOptions = this.changeOptions.bind( this );

        this.state = {
            isAPILoaded: false,
            isAPISaving: false,
            acelr_sib_key: ''
        };
    }

    componentDidMount() {
        wp.api.loadPromise.then( () => {
            this.settings = new wp.api.models.Settings();

            if ( false === this.state.isAPILoaded ) {
                this.settings.fetch().then( response => {
                    this.setState({
                        acelr_sib_key: response.acelr_sib_key,
                        isAPILoaded: true
                    });
                });
            }
        });
    }

    changeOptions( option, value ) {
        this.setState({ isAPISaving: true });

        const model = new wp.api.models.Settings({
            // eslint-disable-next-line camelcase
            [option]: value
        });

        model.save().then( response => {
            this.setState({
                [option]: response[option],
                isAPISaving: false
            });
        });
    }

    render() {
        if ( ! this.state.isAPILoaded ) {
            return (
                <Placeholder>
                    <Spinner/>
                </Placeholder>
            );
        }

        return (
            <Fragment>
                <div className="c-header--admin-header">
                    <div className="c-header__container">

                            <h1 className="c-header__heading" >{ __( 'Email List on Register Settings' ) }</h1>

                    </div>
                </div>

                <div className="codeinwp-main">
                    <PanelBody
                        title={ __( 'Sendinblue Settings' ) }
                    >
                        <PanelRow>
                            <BaseControl
                                label={ __( 'Sendinblue API Key' ) }
                                help={ 'Add your Sendinblue API key' }
                                id="codeinwp-options-google-analytics-api"
                                className="c-form__input--text-admin"
                            >
                                <input
                                    type="text"
                                    id="codeinwp-options-google-analytics-api"
                                    value={ this.state.acelr_sib_key }
                                    placeholder={ __( 'Sendinblue API key' ) }
                                    disabled={ this.state.isAPISaving }
                                    onChange={ e => this.setState({ acelr_sib_key: e.target.value }) }
                                />

                                <div className="codeinwp-text-field-button-group">
                                    <Button
                                        isPrimary
                                        isLarge
                                        disabled={ this.state.isAPISaving }
                                        onClick={ () => this.changeOptions( 'acelr_sib_key', this.state.acelr_sib_key ) }
                                    >
                                        { __( 'Save' ) }
                                    </Button>

                                    <ExternalLink href="#">
                                        { __( 'Get you Sendinblue API Key' ) }
                                    </ExternalLink>
                                </div>
                            </BaseControl>
                        </PanelRow>

                        <PanelRow>
                            <ToggleControl
                                label={ __( 'Track Admin Users?' ) }
                                help={ 'Would you like to track views of logged-in admin accounts?.' }
                                checked={ this.state.codeinwp_analytics_status }
                                onChange={ () => this.changeOptions( 'codeinwp_analytics_status', ! this.state.codeinwp_analytics_status ) }
                            />
                        </PanelRow>
                    </PanelBody>

                    <PanelBody>
                        <div className="codeinwp-info">
                            <h2>{ __( 'Got a question for us?' ) }</h2>

                            <p>{ __( 'We would love to help you out if you need any help.' ) }</p>

                            <div className="codeinwp-info-button-group">
                                <Button
                                    isDefault
                                    isLarge
                                    target="_blank"
                                    href="#"
                                >
                                    { __( 'Ask a question' ) }
                                </Button>

                                <Button
                                    isDefault
                                    isLarge
                                    target="_blank"
                                    href="#"
                                >
                                    { __( 'Leave a review' ) }
                                </Button>
                            </div>
                        </div>
                    </PanelBody>
                </div>
            </Fragment>
        );
    }
}

render(
    <App/>,
    document.getElementById( 'codeinwp-awesome-plugin' )
);

