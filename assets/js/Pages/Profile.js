import React, {Component, Fragment} from 'react';
import {InertiaLink} from "@inertiajs/inertia-react";
import ReactCardFlip from 'react-card-flip';
import {Inertia} from "@inertiajs/inertia";


export default class Profile extends Component{
    constructor(props){
        super(props);
        this.state = {
            firstname: this.props.prop.firstname,
            lastname: this.props.prop.lastname,
            email: this.props.prop.email,
            isFlipped: false
        }
        this.handleClick = this.handleClick.bind(this);
        this.handleFirstNameChange = this.handleFirstNameChange.bind(this);
        this.handleLastNameChange = this.handleLastNameChange.bind(this);
        this.handleEmailChange = this.handleEmailChange.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
    }

    handleClick(e) {
        e.preventDefault();
        this.setState(prevState => ({ isFlipped: !prevState.isFlipped }));
    }

    handleSubmit(event) {
        event.preventDefault();
        const { firstname, lastname, email } = this.state;
        Inertia.post('/users', { firstname, lastname,email });

    }
    handleFirstNameChange(e) {
        this.setState({firstname: e.target.value});
    }
    handleLastNameChange(e) {
        this.setState({lastname: e.target.value});
    }

    handleEmailChange(e) {
        this.setState({email: e.target.value});
    }



    render() {
        console.log(this.props)
        return (
            <Fragment>
                <div className="container">
                    <div className="main-body">
                        <div className="card mb-3">
                            <div className="card-body">
                                <div className="row">
                                    <div className="col-sm-3">
                                        <h6 className="mb-0">Full Name</h6>
                                    </div>
                                    <div className="col-sm-9 text-secondary">
                                        <h5>{this.props.prop.firstname} {this.props.prop.lastname}</h5>
                                    </div>
                                </div>
                                <div className="row">
                                    <div className="col-sm-3">
                                        <h6 className="mb-0">Email</h6>
                                    </div>
                                    <div className="col-sm-9 text-secondary">
                                        <h5>{this.props.prop.email}</h5>
                                    </div>
                                </div>
                                <div className="row">
                                    <div className="col-sm-3">
                                        <h6 className="mb-0">Address</h6>
                                    </div>
                                    <div className="col-sm-9 text-secondary">
                                        <h5>{this.state.firstname}</h5>
                                    </div>
                                </div>
                                <InertiaLink  className="btn btn-primary" href="/editEmail">edit email</InertiaLink >
                                <InertiaLink  className="btn btn-success" href="/detail">Aller au detail</InertiaLink >
                            </div>

                        </div>
                    </div>
                </div>
            </Fragment>

        )
    }
}