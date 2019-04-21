import React from 'react'
import {Link} from 'react-router-dom'

const Block_Grid = props => {
    const description = props.post.description.substring(0, 150);
    return (
        <div className="col-md-6">
            <div className="blog-item">
                <img className="blog-thumb set-bg img-thumbnail" src={'../' + props.post.file_path}/>
                <div className="blog-content">
                    <Link to={"/blog/" + props.post.id}>
                        <h6>{props.post.title}</h6></Link>
                    <div className="blog-meta">
                        <span><i className="fa fa-calendar-o"></i> {props.post.created_at}</span>
                    </div>
                    <p>{description} <Link to={"/blog/" + props.post.id}
                                           className="text-green">
                        read more</Link>
                    </p>
                </div>
            </div>
        </div>
    )
}

export default Block_Grid