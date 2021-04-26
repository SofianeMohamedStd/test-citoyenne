import React, {Component, Fragment} from 'react';
import {InertiaLink} from "@inertiajs/inertia-react";
import ReactCardFlip from 'react-card-flip';
import {Inertia} from "@inertiajs/inertia";

export default class EditEmail extends Component{
    constructor(props) {
        super(props);
        this.state = {
            email: this.props.prop.email,
        }
        this.handleClick = this.handleClick.bind(this);
        this.handleEmailChange = this.handleEmailChange.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
    }
    handleClick(e) {
        e.preventDefault();
        this.setState(prevState => ({ isFlipped: !prevState.isFlipped }));
    }

    handleSubmit(event) {
        event.preventDefault();
        const { email } = this.state;
        Inertia.post('/confirmEditEmail', { email });
    }

    handleEmailChange(e) {
        this.setState({email: e.target.value});
    }

    render() {
        return (
            <form onSubmit={this.handleSubmit}>
                <label>
                    Email :
                    <input type="text" id="email" value={this.state.email} onChange={this.handleEmailChange} required/>
                </label>
                <button className="btn btn-secondary" type="submit">edit</button>
            </form>
        )
    }
}