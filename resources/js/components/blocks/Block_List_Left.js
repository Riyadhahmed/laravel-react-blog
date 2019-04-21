import React from 'react'
import {Link} from 'react-router-dom'

const Block_List_Left = props => {
    return (
        <div className="recent-post-widget">
            <div className="rp-item">
                <img className="rp-thumb set-bg " src={'../' + props.post.file_path}/>
                <div className="rp-content">
                    <Link to={"/blog/" + props.post.id}>
                        <h6>{props.post.title}</h6></Link>
                    <p><i className="fa fa-clock-o"></i> {props.post.created_at}</p>
                </div>
            </div>
        </div>
    )
}

export default Block_List_Left